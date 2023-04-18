<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles.css')}}">
</head>

<body>

<style>
    .login-wrapper {
        display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: center;
        padding: 20px;
        width: 100vw;
        height: 100vh;
    }

    .login-wrapper .logo-wrapper img {
        width: 149px;
    }

    #formContent {
        background: #ffffff;
        padding: 20px 0;
        width: 100%;
        max-width: 460px;
        position: relative;
        text-align: center;
        border-radius: 3px;
        -o-box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.2);
    }
</style>

<div class="login-wrapper fadeInDown">
    <div id="formContent">
        <div class="fadeIn first">
            <a href="#" class="logo-wrapper"><img src="{{asset('img/logo.jpg')}}" alt="icon"/></a>
            <p class="mt-3" style="font-size: 17px;font-weight: 500;color: #324358;margin-bottom: 40px;">
                @yield('form_title')
            </p>
        </div>

        @yield('main_container')
    </div>
</div>

<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>

@yield('js')

</body>
</html>
