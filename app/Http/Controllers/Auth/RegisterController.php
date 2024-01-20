<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Auth\RegistrationRequest;
use Illuminate\Support\Facades\Hash ;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    // Registration Function 
    public function register(RegistrationRequest $request){
        try {
            // After Process Validations 
            $newuser = $request->validated();
        } catch (ValidationException $e) {
            // If Find Errors Validated
            return ApiResponse::sendResponse(422, 'Register Validations Errors', $e->validator->messages()->all());
        }
        // Encode Password 
        $newuser['password'] = Hash::make($newuser['password']);
        // Permations User Set 
        $newuser['role'] = 'user';
        // Status User 
        $newuser['status'] = 'active';
        // Create New User In DataBase
        $user= User::create($newuser);
        // Create Token Afeter Save 
        $success['token'] = $user->createToken('user',['app:all'])->plainTextToken;
        $success['name'] = $user->first_name;
        $success['success'] = true; 
        return ApiResponse::sendResponse(201, 'Add New User Successfully ',[$success]);

    }
}
