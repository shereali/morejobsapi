<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome To {{env('APP_NAME')}}</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #404040;
            font-family: 'Roboto', sans-serif;
            font-size: 14px;
        }

        p {
            line-height: 22px;
        }

        p.small {
            font-size: 0.75em;
        }

        a {
            text-decoration: none;
        }

        .main-wrapper {
            max-width: 600px;
            margin: 0 auto;
        }

        .em-wrapper {
            width: 100%;
            height: 100%;
            background-repeat: repeat;
            background-position: center top;
        }

        .btn {
            padding: 10px 15px;
            color: #fff;
            background: #2D7AF1;
            border-radius: 3px;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="main-wrapper">
    <table class="em-wrapper" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <td>
                <div style="border-radius: 3px;box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);">
                    <table style="width: 100%;background: #2D7AF1;padding: 15px">
                        <tbody>
                        <tr>
                            <td>
                                <img src="{{asset('img/logo.jpg')}}" style="width: 180px" alt="MorejobsBD">
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table style="width: 100%;padding: 35px 25px;background: #f2f4f9;">
                        <tbody>
                        <tr>
                            <td>
                                <div style="text-align: center">
                                    <h1 style="font-size: 39px;font-weight: 300;margin: 0;">Welcome</h1>
                                    <p>Hi, {{@$user->first_name}} {{@$user->last_name}} we’re {{env('APP_NAME')}} excited
                                        to
                                        team up with you! Our tools and intelligence are designed to help you run and
                                        grow
                                        your business. We want to share some quick recommendations to help you get off
                                        to a
                                        strong start.</p>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
