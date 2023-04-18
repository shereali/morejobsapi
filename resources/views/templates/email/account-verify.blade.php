@extends('templates.email.app')

@section('main_container')
    <table class="outer-table">
        <tbody>
        <tr>
            <td>
                <table class="inner-table" style="margin-top: 20px; background: #fff">
                    <tbody>
                    <tr>
                        <td>
                            <table style="width: 96%;margin: 10px auto;">
                                <tbody>
                                <tr>
                                    <td><h3 style="font-size: 24px; margin: 0;">Account verification code</h3></td>
                                </tr>
                                <tr>
                                    <td style="padding-top: 10px;padding-bottom: 0;">
                                        <h6 style="font-size: 16px;margin-block-start: 0;margin-block-end: 0; margin: 0;">
                                            Dear {{$user->first_name}} {{$user->last_name}}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <p>Your verification code is:
                                            <strong>{{$user->account_verification_token}}</strong>.
                                            Please use this code to verify your {{env('APP_NAME')}} account.</p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@endsection
