<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerificationRequest;
use App\Models\User;
use Ichtrojan\Otp\Models\Otp;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Notifications\EmailVerificationNotification;
class EmailVerificationController extends Controller
{
    private $otp;
    public function __construct() {
        $this->otp= new Otp;
        
    }

    public function sendEmailVerification(Request $request){
        $request->user()->notify(new EmailVerificationNotification() );
        $success['success'] = true;
        return ApiResponse::sendResponse(200, 'Verification Successfully ',[$success]);
    }
    public function email_verification(EmailVerificationRequest $request){
        try {
        // Check OTP
        $otp2 = $this->otp->validate($request->email,$request->otp);
        if(!$otp2->status){
            return ApiResponse::sendResponse(401, 'Error OTP ',[$otp2->Error]);
        }
        } catch (ValidationException $e) {
            // If Find Errors Validated
            return ApiResponse::sendResponse(422, 'Verification Validations Errors', $e->validator->messages()->all());
        }
   
        // Is Success 
        $user = User::where('email',$request->email)->first();
        $user->update(['email_verified_at'=>now()]);
        $success['success'] = true;
        return ApiResponse::sendResponse(200, 'Verification Successfully ',[$success]);
    }
}
