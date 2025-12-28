<!DOCTYPE html><html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-style-mode" content="1">
    <title>Sign In</title>
    <link rel="icon" href="{{asset('public/images/icon.png')}}">
    <link rel="apple-touch-icon" href="{{asset('public/images/icon.png')}}">
    <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/feature.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/style.css')}}">
    <style>
        html, body {
            max-width: 100%;
            overflow-x: hidden;
        }
        .three-body {position: relative;display: inline-block;height: 35px;width: 35px;animation: spin78236 2s infinite linear;}
        .three-body__dot {position: absolute;height: 100%;width: 30%;}
        .three-body__dot:after {content: '';position: absolute;height: 0%;width: 100%;padding-bottom: 100%;background-color: #5D3FD3;border-radius: 50%;}
        .three-body__dot:nth-child(1) {bottom: 5%;left: 0;transform: rotate(60deg);transform-origin: 50% 85%;}
        .three-body__dot:nth-child(1)::after {bottom: 0;left: 0;animation: wobble1 0.8s infinite ease-in-out;animation-delay: -0.24s;}
        .three-body__dot:nth-child(2) {bottom: 5%;right: 0;transform: rotate(-60deg);transform-origin: 50% 85%;}
        .three-body__dot:nth-child(2)::after {bottom: 0;left: 0;animation: wobble1 0.8s infinite -0.12s ease-in-out;}
        .three-body__dot:nth-child(3) {bottom: -5%;left: 0;transform: translateX(116.666%);}
        .three-body__dot:nth-child(3)::after {top: 0;left: 0;animation: wobble2 0.8s infinite ease-in-out;}
        @keyframes spin78236 {
            0% {transform: rotate(0deg);}
            100% {transform: rotate(360deg);}
        }
        @keyframes wobble1 {
            0%, 100% {transform: translateY(0%) scale(1);opacity: 1;}
            50% {transform: translateY(-66%) scale(0.65);opacity: 0.8;}
        }
        @keyframes wobble2 {
            0%, 100% {transform: translateY(0%) scale(1);opacity: 1;}
            50% {transform: translateY(66%) scale(0.65);opacity: 0.8;}
        }
        .basic-info-container, .otp-container, .form-loader{display: none;}
        .error{color: #c64d4d;display: block;text-align: left;}
        .disable-button{opacity: 0.6;cursor: not-allowed;pointer-events: none;}
        .show-inline {display: inline-block !important;}
        .institute-logo{border-radius: 10px;}
        
    </style>
</head>

<body>
    <main class="page-wrapper">
        <div class="signup-area">
            <div class="wrapper">
                <div class="row">
                    <div class="col-lg-12 bg-color-blackest left-wrapper">
                        <div class="sign-up-box">
                            <div class="signup-box-top">
                                @if(!is_null($institute) && Storage::disk('public')->exists($institute->logo))
                                <div class="row">
                                    <div class="col-md-6 col-6">
                                        <img src="{{ asset('public/images/logo.png') }}" alt="sign-up logo">
                                    </div>
                                    <div class="col-md-6 col-6">
                                        <img src="{{ Storage::disk('public')->url($institute->logo) }}" class="institute-logo">
                                    </div>
                                </div>
                                @else
                                <img src="{{ asset('public/images/logo.png') }}" alt="sign-up logo">
                                @endif
                            </div>
                            <div class="signup-box-bottom">
                                <div class="signup-box-content">
                                    <div class="three-body form-loader">
                                        <div class="three-body__dot"></div>
                                        <div class="three-body__dot"></div>
                                        <div class="three-body__dot"></div>
                                    </div>
                                    @if ($errors->has('error'))
                                        <div class="alert alert-danger alert-dismissible fade show error-message" role="alert">
                                            {{ $errors->first('error') }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif
                                    <form action="{{route('student.passwordLogin')}}" method="POST" id="login-form">
                                        @csrf
                                        <div class="input-section">
                                            <div class="icon"><i class="feather-user"></i></div>
                                            <input type="text" placeholder="Phone / Email" name="username" id="username" value="{{old('username')}}">
                                        </div>
                                        <div class="input-section">
                                            <div class="icon"><i class="feather-user"></i></div>
                                            <input type="password" placeholder="Password" name="password" value="{{old('password')}}">
                                        </div>
                                        <button type="submit" class="btn-default submit-btn">Submit</button>
                                    </form>
                                </div>
                                <div class="signup-box-footer">
                                    <div class="bottom-text">
                                        Forgot Password? <a class="btn-read-more ml--5" href="{{ route('student.forgot-password') }}"><span>Click Here</span></a>
                                    </div>
                                    <div class="bottom-text">
                                        Don't have account? <a class="btn-read-more ml--5" href="{{ route('student.register') }}"><span>Create One</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="close-button" href="{{ route('home') }}">
                <i class="fa-sharp fa-regular fa-x"></i>
            </a>
        </div>
    </main>

    <div class="rbt-progress-parent">
        <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
        </svg>
    </div>
    <!-- <script src="{{asset('js/modernizr.min.js')}}"></script> -->
    <script src="{{asset('public/js/jquery.min.js')}}"></script>
    <script src="{{asset('public/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('public/js/waypoint.min.js')}}"></script>
    <script src="{{asset('public/js/wow.min.js')}}"></script>
    <script src="{{asset('public/js/counterup.min.js')}}"></script>
    <script src="{{asset('public/js/sal.min.js')}}"></script>
    <script src="{{asset('public/js/slick.min.js')}}"></script>
    <script src="{{asset('public/js/text-type.js')}}"></script>
    <script src="{{asset('public/js/prism.js')}}"></script>
    <script src="{{asset('public/js/jquery.style.swicher.js')}}"></script>
    <script src="{{asset('public/js/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('public/js/backto-top.js')}}"></script>

    <script src="{{asset('public/js/js.cookie.js')}}"></script>
    <script src="{{asset('public/js/jquery-one-page-nav.js')}}"></script>
    <!-- Main JS -->
    <script src="{{asset('public/js/main.js')}}"></script>
    <script src="{{asset('public/js/plugins/validate/jquery.validate.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $.validator.addMethod("emailOrPhone", function(value, element) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const phoneRegex = /^[0-9]{10}$/; // 10-digit phone number
                return this.optional(element) || emailRegex.test(value) || phoneRegex.test(value);
            }, "Please enter a valid email or 10-digit phone number");
            $("#login-form").validate({
                rules: {
                    username: {
                        required: true,
                        emailOrPhone: true
                    },
                    password: {
                        required: true
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element.parent());
                }
            });
        });
    </script>

</body>
</html>