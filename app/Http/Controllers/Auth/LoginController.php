<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Helpers\ApiResponse;
use App\Notifications\LoginNotification;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{

    public function login(LoginRequest $request)
    {
        try {
            // Make Manual Validations
            $validator = $request->validated();
        } catch (ValidationException $e) {
            return ApiResponse::sendResponse(422, 'Login Validations Errors', $e->validator->messages()->all());
        }
        // Get Data 
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        // Check Data Login In For Database
        if(Auth::attempt($credentials))
        {
        // After Check And Approve Login
        $user = Auth::user();
        $user->tokens()->delete();
        $success['token'] = $user->createToken(request()->userAgent())->plainTextToken;
        $success['name'] = $user->first_name;
        $success['success'] = true; 

        // After Process Login Send Notefications Logged
        // Must Realy Email
        // $user->notify(new LoginNotification());

        return ApiResponse::sendResponse(200,'User Logged in Successfully', $success);
         }else{

        return ApiResponse::sendResponse(401,' User Credentiats doesn\'t exist ', null);
        }


    }
 
}
