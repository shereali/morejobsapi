<?php

namespace App\Services;

use App\Mail\AccountCreated;
use App\Mail\AccountVerify;
use App\Mail\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Propaganistas\LaravelPhone\PhoneNumber;

class AccountService
{
    public static function validatePhoneNo($value, $key = 'phonefield', $countryCode = 'BD')
    {
        $request = new Request();
        $request[$key] = $value;

        $validator = Validator::make($request->all(), [$key => "phone:$countryCode,mobile"], ['phone' => 'This :attribute is invalid.']);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->messages()->toArray());
        }

        return true;
    }

    public static function isEmailOrMobile($username, $countryCode = 'BD'): int
    {
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            return StaticValueService::regMediumId('email');
        }

        $request = new Request();
        $request['email_or_mobile'] = $username;

        $validator = Validator::make($request->all(), ['email_or_mobile' => "phone:$countryCode,mobile"], ['phone' => 'This :attribute is invalid.']);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->messages()->toArray());
        }

        return StaticValueService::regMediumId('mobile');
    }

    public static function getFormattedPhoneNo($phoneNo, $countryCode = 'BD'): string
    {
        return (string) phone($phoneNo,$countryCode);
    }

    public static function generateVerificationToken(): int
    {
        return mt_rand(10000, 99999);
    }

    public static function sendVerificationCode($user): bool
    {
        if ($user->reg_medium['id'] == StaticValueService::regMediumId('email')) {
            $mailClass = new AccountVerify($user);
            return MailService::mailSend($user->username, $mailClass);
        }

        return SmsService::sendSms([
            'phone_number' => $user->username,
            'message' => SmsService::getAccountVerificationMessage($user->account_verification_token),
        ]);
    }

    public static function sendWelcomeMessage($user): bool
    {
        try {
            if ($user->reg_medium['id'] == StaticValueService::regMediumId('email')) {
                $mailClass = new AccountCreated($user);
                return MailService::mailSend($user->username, $mailClass);

            }

            return SmsService::sendSms([
                'phone_number' => $user->username,
                'message' => SmsService::getWelcomeMessage($user),
            ]);

        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    public static function sendPasswordResetCode($username, $code, $regMedium = 1, $user = null): bool
    {
        try {
            if ($regMedium['id'] == StaticValueService::regMediumId('email')) {
                $mailClass = new PasswordReset($user);

                return MailService::mailSend($username, $mailClass);
            }

            return SmsService::sendSms([
                'phone_number' => $username,
                'message' => SmsService::getPasswordResetMessage($code),
            ]);

        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    public static function isRightPassword($user, $givenPassword): bool
    {
        return Hash::check($givenPassword, $user->password);
    }


//    public static function getExpireDate($qty, $isMonthly = 1)
//    {
//        if ($isMonthly) {
//            return Carbon::now()->addMonths($qty);
//        }
//        return Carbon::now()->addYears($qty);
//    }

//    public static function getTimezoneByName($timezoneName)
//    {
//        return Timezone::whereTitle($timezoneName)->firstOrFail();
//    }

//    public static function getDefaultDateFormat()
//    {
//        return DateFormat::whereIsDefault(1)->firstOrFail();
//    }

    /*public static function getReminderAfterDate($value, $expireDate)
    {
        return Carbon::parse($expireDate)->subDays($value);
    }*/
}
