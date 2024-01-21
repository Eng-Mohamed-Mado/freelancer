<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Helpers\ApiResponse;
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

        // Check Data Login In For Database
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
        // After Check And Approve Login
        $user = Auth::user();

        $data['token'] = $user->createToken('ApiCourse')->plainTextToken;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        return ApiResponse::sendResponse(200,'User Logged in Successfully', $data);

         }else{

        return ApiResponse::sendResponse(401,' User Credentiats doesn\'t exist ', null);
        }


    }
 
}
