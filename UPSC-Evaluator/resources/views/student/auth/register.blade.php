<!DOCTYPE html><html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-style-mode" content="1">
    <title>Sign Up</title>
    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.png">
    <link rel="stylesheet" href="{{asset('public/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/feature.css')}}">
    <!-- <link rel="stylesheet" href="{{asset('public/css/animation.css')}}"> -->
    <!-- <link rel="stylesheet" href="{{asset('public/css/slick.css')}}"> -->
    <!-- <link rel="stylesheet" href="{{asset('public/css/slick-theme.css')}}"> -->
    <!-- <link rel="stylesheet" href="{{asset('public/css/bootstrap-select.min.css')}}"> -->
    <!-- <link rel="stylesheet" href="{{asset('public/css/prism.css')}}"> -->
    <link rel="stylesheet" href="{{asset('public/css/style.css')}}">
    <style>
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
        .basic-info-container, .otp-container, .form-loader, .invalid-otp-error-message, .error-message, .success-message, .resend-otp-container, .otp-expire-container{display: none;}
        .error{color: #c64d4d;display: block;text-align: left;}
        .disable-button{opacity: 0.6;cursor: not-allowed;pointer-events: none;}
        .show-inline {display: inline-block !important;}
    </style>
</head>

<body>
    <main class="page-wrapper">
        <div class="signup-area">
            <div class="wrapper">
                <div class="row">
                    <div class="col-lg-6 bg-color-blackest left-wrapper">
                        <div class="sign-up-box">
                            <div class="signup-box-top">
                                <img src="{{ asset('public/images/logo.png') }}" alt="sign-up logo">
                            </div>
                            <div class="signup-box-bottom">
                                <div class="signup-box-content">
                                    <div class="three-body form-loader">
                                        <div class="three-body__dot"></div>
                                        <div class="three-body__dot"></div>
                                        <div class="three-body__dot"></div>
                                    </div>
                                    <div class="alert alert-danger alert-dismissible fade show invalid-otp-error-message" role="alert">
                                        Invalid OTP
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <div class="alert alert-danger alert-dismissible fade show error-message" role="alert">
                                        <span class="error-message-container"></span>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <div class="alert alert-success alert-dismissible fade show success-message" role="alert">
                                        <span class="success-message-container"></span>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <div class="alert alert-success alert-dismissible fade show otp-expire-container" role="alert" @if(!is_null($user) && !$user->is_registered) style="display: block;" @endif>
                                        Resend OTP in <span class="second">30</span> seconds.
                                    </div>
                                    <form action="{{route('student.register.store')}}" method="POST" id="register-form">
                                        @csrf
                                        <div class="input-section phone-container" @if(!is_null($user)) style="display: none;" @endif>
                                            <div class="icon"><i class="fa-solid fa-phone"></i></div>
                                            <input type="number" placeholder="Enter Your Phone" name="phone" id="phone">
                                        </div>
                                        <div class="input-section otp-container" @if(!is_null($user)) style="display: {{ !$user->is_registered ? 'block' : 'none' }};" @endif>
                                            <div class="icon"><i class="feather-user"></i></div>
                                            <input type="number" placeholder="Enter Your OTP" name="otp">
                                        </div>
                                        <div class="forget-text resend-otp-container"><span><a class="btn-read-more resend-otp resend-otp-container" href="javascript:void(0);"><span>Resend OTP</span></a></span></div>
                                        <div class="input-section mail-section basic-info-container" @if(!is_null($user) && $user->is_registered) style="display: block;" @endif>
                                            <div class="icon"><i class="fa-solid fa-user"></i></div>
                                            <input type="text" placeholder="Full Name" name="name">
                                        </div>
                                        <div class="input-section mail-section basic-info-container" @if(!is_null($user) && $user->is_registered) style="display: block;" @endif>
                                            <div class="icon"><i class="fa-sharp fa-regular fa-envelope"></i></div>
                                            <input type="email" placeholder="Email address (Optional)" name="email" id="email">
                                        </div>
                                        <div class="input-section password-section basic-info-container" @if(!is_null($user) && $user->is_registered) style="display: block;" @endif>
                                            <div class="icon"><i class="fa-sharp fa-regular fa-lock"></i></div>
                                            <input type="password" placeholder="Create Password" name="password" id="password">
                                        </div>
                                        <div class="input-section password-section basic-info-container" @if(!is_null($user) && $user->is_registered) style="display: block;" @endif>
                                            <div class="icon"><i class="fa-sharp fa-regular fa-lock"></i></div>
                                            <input type="password" placeholder="Confirm Password" name="confirm_password">
                                        </div>
                                        <button type="submit" class="btn-default submit-btn">{{ $button_message }}</button>
                                    </form>
                                </div>
                                <div class="signup-box-footer">
                                    <div class="bottom-text">
                                        Do you have an account? <a class="btn-read-more ml--5" href="signin.html"><span>Sign In</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 right-wrapper">
                        <div class="client-feedback-area">
                            <div class="single-feedback">
                                <div class="inner">
                                    <div class="meta-img-section">
                                        <a class="image" href="#">
                                            <img src="{{ asset('public/images/team-02sm.jpg') }}" alt="">
                                        </a>
                                    </div>
                                    <div class="rating">
                                        <a href="#rating">
                                            <i class="fa-sharp fa-solid fa-star"></i>
                                        </a>
                                        <a href="#rating">
                                            <i class="fa-sharp fa-solid fa-star"></i>
                                        </a>
                                        <a href="#rating">
                                            <i class="fa-sharp fa-solid fa-star"></i>
                                        </a>
                                        <a href="#rating">
                                            <i class="fa-sharp fa-solid fa-star"></i>
                                        </a>
                                        <a href="#rating">
                                            <i class="fa-sharp fa-solid fa-star"></i>
                                        </a>
                                    </div>
                                    <div class="content">
                                        <p class="description">Pixcels-Themes is now a crucial component of our work! We made it simple to collaborate across departments by grouping our work</p>
                                        <div class="bottom-content">
                                            <div class="meta-info-section">
                                                <h4 class="title-text mb--0">Guy Hawkins</h4>
                                                <p class="desc mb--20">Nursing Assistant</p>
                                                <div class="desc-img">
                                                    <img src="{{ asset('public/images/brand-t.png') }}" alt="Brand Image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="close-button" href="">
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
        let timer = null;
        $(document).ready(function(){
            @if(!is_null($user) && !$user->is_registered)
            resetOTP();
            @endif
            $("#register-form").validate({
                rules: {
                    phone: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        remote: {
                            url: "{{route('student.register.check-field')}}",
                            type: "GET",
                            data: {
                                phone: function() {
                                    return $('#phone').val();
                                }
                            }
                        }
                    },
                    name: {
                        required: true
                    },
                    email: {
                        email: true,
                        remote: {
                            url: "{{route('student.register.check-field')}}",
                            type: "GET",
                            data: {
                                email: function() {
                                    return $('#email').val();
                                }
                            }
                        }
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    confirm_password: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    phone: {
                        remote: "Account with this number is already exists!"
                    },
                    email: {
                        remote: "This email is already exists!"
                    },
                    confirm_password: {
                        equalTo: "This is not match with password"
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element.parent());
                },
                submitHandler: function(form){
                    let form_data = $('#register-form')
                            .find(':input')
                            .filter(function () {
                                return $(this).is(':visible') || $(this).attr('name') === '_token';
                            })
                            .serialize(); 
                    $.ajax({
                        url: "{{ route('student.register.store') }}",
                        method: "POST",
                        data: form_data,
                        beforeSend: function(){
                            $(".form-loader").addClass("show-inline");
                            $(".submit-btn").addClass('disable-button');
                        },
                        success: function(response) {
                            if (response.success) {
                                window.location.href = response.redirect_url;
                            } else {
                                if('otp_not_send' in response) {
                                    alert(response.otp_not_send);
                                }
                                $(".form-loader").removeClass("show-inline");
                                $(".submit-btn").removeClass('disable-button');
                                $("."+response.elements.hide_element).hide();
                                $("."+response.elements.show_element).show();
                                if (response.elements.show_element == 'otp-container') {
                                    resetOTP();
                                } else {
                                    $(".otp-expire-container").hide();
                                }
                                if ("otp_invalid" in response) {
                                    $(".invalid-otp-error-message").show();   
                                } else {
                                    $(".invalid-otp-error-message").hide();   
                                }
                            }
                            $(".submit-btn").text(response.button_message);
                        }
                    })
                }
            });
        });
        $(".resend-otp").on('click', function(){
            $.ajax({
                url: "{{ route('student.otpResend', ['register_event']) }}",
                method: "GET",
                beforeSend: function(){
                    $(".form-loader").addClass("show-inline");
                    $(".submit-btn").addClass('disable-button');
                },
                success: function(response) {
                    $(".form-loader").removeClass("show-inline");
                    $(".submit-btn").removeClass('disable-button');
                    if ("error_message" in response) {
                        $(".error-message-container").text(response.error_message);
                        $(".error-message").show();   
                    } else {
                        $(".error-message-container").text('');
                        $(".error-message").hide();   
                    }
                    if ("success_message" in response) {
                        $(".success-message-container").text(response.success_message);
                        $(".success-message").show();   
                    } else {
                        $(".success-message-container").text('');
                        $(".success-message").hide();   
                    }
                    $(".resend-otp-container").hide();
                    resetOTP();
                }
            })
        });
        function resetOTP() {
            if (timer !== null) {
                clearInterval(timer);
            }

            let secondsLeft = 30;

            $(".resend-otp-container").hide();
            $(".otp-expire-container").show();
            $(".second").text(secondsLeft);

            timer = setInterval(function () {
                secondsLeft--;
                $('.second').text(secondsLeft);

                if (secondsLeft < 0) {
                    clearInterval(timer);
                    timer = null;

                    $(".resend-otp-container").show();
                    $(".otp-expire-container").hide();
                }
            }, 1000);
        }
    </script>

</body>
</html>