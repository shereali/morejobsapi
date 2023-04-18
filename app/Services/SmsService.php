<?php

namespace App\Services;

class SmsService
{
    public static function sendSms($data): bool
    {
        $client = new \GuzzleHttp\Client();

        try {
            $request = $client->post('http://esms.dianahost.com/smsapi', [
                'form_params' => [
//                    'api_key' => 'C20031345c6bc829303282.52919123',
//                    'type' => 'text',
//                    'contacts' => $data['phone_number'],
//                    'senderid' => 'Sadagar',
//                    'msg' => $data['message'],
                ]
            ]);

            $response = $request->getBody();
//            $errors = ['1002', '1003', '1004', '1005', '1006', '1007', '1008', '1009', '1010', '1011', '1012'];
//            if (in_array($response, $errors)) {
//                $smsError = null;
//
//                switch ($response) {
//                    case '1002':
//                        $smsError = $response . ' Sender Id/Masking Not Found.';
//                        break;
//                    case '1003':
//                        $smsError = $response . ' API Not Found.';
//                        break;
//                    case '1004':
//                        $smsError = $response . ' SPAM Detected.';
//                        break;
//                    default:
//                        $smsError = $response . ' Sms error.';
//                }
//            }

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    public static function getAccountVerificationMessage($OTP): string
    {
        return 'Your ' . env('APP_NAME') . ' account verification code is ' . $OTP . '. Please use this code to verify your account.';
    }

    public static function getPasswordResetMessage($OTP): string
    {
        return 'Your ' . env('APP_NAME') . ' account password reset code is ' . $OTP . '. Please use this code to change password.';
    }

    public static function getWelcomeMessage($user): string
    {
        return "Hi, $user->first_name $user->last_name welcome to " . env('APP_NAME') . "we’re excited to team up with
                        you! Our tools and intelligence are designed to help you run and grow your business";
    }
}
