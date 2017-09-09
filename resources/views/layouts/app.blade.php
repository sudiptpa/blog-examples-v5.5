<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
            .message{
                padding: 13px;
                color: #fff;
                border-radius: 3px;
                background: linear-gradient(90deg,#040432 2.8%,#016bde 90.9%);
            }
            hr {
                border: 1px solid #dfdfdf;
            }
            .gateway--info{
                padding-top: 200px;
                 margin-bottom: 70px;
            }
            .clearfix{
                clear: both;
            }
            .btn{
                display: inline-block;
                overflow: visible;
                margin: 0;
                padding: 0 32px;
                height: 48px;
                border: 0;
                border-radius: 3px;
                background: #ececec;
                color: #333;
                vertical-align: middle;
                text-align: center;
                text-decoration: none;
                text-transform: none;
                white-space: nowrap;
                font: inherit;
                font-weight: 600;
                font-size: 16px;
                line-height: 48px;
                cursor: pointer;
                transition: all .25s cubic-bezier(.645,.045,.355,1);
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
            }
            .btn-pay{
                background: #0069ff;
                color: #fff;
            }
            input[type=range] {
                -webkit-appearance: none;
                background: #EFEEEF;
                padding: 0px;
                border: 0px !important;
                height: 30px;
                width: inherit;
            }
            input[type=radio] {
                height: 24px;
                width: 24px;
            }
            input[type=radio]::-webkit {
                background: #000;
            }
            input[type=range]::-webkit-slider-runnable-track {
                width: 100%;
                height: 7px;
                background: #aaa;
                border: #EFEEEF;
                border-radius: 3px;
                color: red;
            }
            input[type=range]::-webkit-slider-thumb {
                -webkit-appearance: none;
                border: 40px;
                border-color: #EFEEEF;
                height: 25px;
                width: 25px;
                border-radius: 50%;
                background: black;
                margin-top: -9px;
            }
            input[type=range]:focus {
                outline: none;
            }
            input[type=range]:focus::-webkit-slider-runnable-track {
                background: #ccc;
            }
            input[type=range]::-moz-range-track {
                height: 10px;
                border: none;
                border-radius: 3px;
            }
            input[type=range]::-moz-range-thumb {
                height: 25px;
                width: 25px;
                border-radius: 50%;
                background: black;
                margin-top: -9px;
            }

            input[type=range]:-moz-focusring {
                outline-offset: -1px;
            }
            input[type=range]:focus::-moz-range-track {
                background: #ccc;
            }
            input[type=range]::-ms-track {
                width: 100%;
                height: 7px;
                background: transparent;
                border-color: transparent;
                border-width: 6px 0;
                color: transparent;
            }
            input[type=range]::-ms-fill-lower {
                background: #777;
                border-radius: 10px;
            }
            input[type=range]::-ms-fill-upper {
                background: #ddd;
                border-radius: 10px;
            }
            input[type=range]::-ms-thumb {
                height: 25px;
                width: 25px;
                border-radius: 50%;
                background: black;
                margin-top: -3px;
            }
            input[type=range]:focus::-ms-fill-lower {
                background: #888;
            }
            input[type=range]:focus::-ms-fill-upper {
                background: #ccc;
            }
            input[type=range]::-ms-tooltip {
                display: none;
            }
            .lc-page1,
            .lc-page2,
            .lc-page3 {
                font-family: "Segoe UI", "DejaVu Sans", "Trebuchet MS", Verdana, sans- serif;
                font-size: 14px;
                color: #000;
                padding: 20px;
                background: #EFEEEF;
            }
            .lc-intro {
                font-size: 24px;
            }
            .lc-loan-repayment-col {
                width: 1%;
                text-align: center;
                vertical-align: top;
            }
            .lc-loan-repayment-text {
                padding: 2px;
            }
            .lc-loan-tbl {
                width: 100%;
            }
            .lc-loan-tbl-row {} .lc-loan-tbl-title {
                width: 33%;
            }
            .lc-loan-tbl-value {
                width: 100%;
            }
            .lc-loan-tbl-rate {
                white-space: nowrap;
                padding-right: 20px;
            }
            .lc-repayment-intro {} .lc-button {
                padding: 5px 15px;
                background: #8E8E8E;
                color: #000;
                border: 0;
                font-size: 18px;
                border-radius: 4px;
            }
            .lc-details {} .lc-loan-details-tbl {} .lc-loan-details-title {} .lc-loan-details-value {} .lc-button-link {
                background: none !important;
                border: none;
                padding: 0 !important;
                font: inherit;
                cursor: pointer;
                color: darkblue;
            }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
        <div class="footer">
            @yield('footer')
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
