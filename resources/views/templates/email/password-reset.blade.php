@extends('templates.email.app')

@section('title',  env('APP_NAME').' - Reset your password')

@section('main_container')
    <table style="width: 100%;padding: 0 15px;background: #ffffff;">
        <tbody>
        <tr>
            <td>
                <table
                    style="width: 100%;padding: 30px 15px;background: #ffffff;border-radius: 3px;box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);text-align: center;">
                    <tbody>
                    <tr>
                        <td>
                            <div style="width: 100%">
                                <p style="font-size: 17px;font-weight: 500;color: #324358;">Password reset code</p>
                                <p style="font-size: 29px;font-weight: 700;color: #324358;margin: 25px 0;">{{$user->account_verification_token}}</p>
                                <p style="margin: 0;color: #333;font-size: 16px;font-weight: 500;">Hi there,</p>
                                <p style="padding: 0 20px;font-size: 14px;font-weight: 400;">We received a password
                                    reset request for your {{env('APP_NAME')}} account. If you did not request a
                                    password change,
                                    please ignore this message.</p>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
