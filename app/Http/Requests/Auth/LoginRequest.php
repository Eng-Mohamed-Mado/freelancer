<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use App\Helpers\ApiResponse;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        // Run This Function Is Status Error Validations 422
        // Any Route EndPoint Afte Api/*
        if($this->is('api/*'))
        {
            // Return Error With Message Only
            // $response = ApiResponse::sendResponse(422,'Validations Errors',$validator->messages()->all());

            // Return Error With Message And Name Faild
            $response = ApiResponse::sendResponse(422,'Login Validations Errors',$validator->errors());

            // Pass Error With Style Data In Method Validations Exceptions
            throw new ValidationException($validator,$response);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'=>'required|email',
            'password'=>'required',
        ];
    }
}
