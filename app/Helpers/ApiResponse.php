<?php
namespace App\Helpers;
class ApiResponse
{
    static function sendResponse($code = 200,$msg = null , $data = null)
    {
        $response = [
            'status' => $code,
            'Message' => $msg,
            'Data' => $data,
        ];

        return response()->json($response,$code);
    }
}
