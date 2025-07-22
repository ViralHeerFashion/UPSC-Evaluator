<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UPSE Evaluator | Log in</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('admin/assets/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/assets/dist/css/adminlte.min.css')}}">
    <style>
        .error-msg{color: red;}
        .cursor-pointer{cursor: pointer;}
    </style>
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="javascript:void(0);" class="h1"><b>UPSE </b>Evaluator</a>
            </div>
            <div class="card-body">
                @error('error_message')
                    @foreach ($errors->all() as $error)
                        <p class="error-msg text-center">{{ $error }}</p>
                    @endforeach
                @enderror
                
                @if(session()->has('msg'))
                <div class="alert alert-success mb-3" role="alert">{{session('msg')}}</div>
                @endif

                <form action="{{route('admin.authenticate')}}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" id="password" name="password" required>
                        <div class="input-group-append password-handle">
                            <div class="input-group-text cursor-pointer password-icon-container">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <!-- <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div> -->
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('admin/assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admin/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('admin/assets/dist/js/adminlte.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $(".password-handle").on('click', function(){
                if ($("#password").attr('type') == "password") {
                    $("#password").attr('type', 'text');
                    $(".password-icon-container").html(`<i class="fas fa-eye-slash"></i>`);
                } else {
                    $("#password").attr('type', 'password');
                    $(".password-icon-container").html(`<i class="fas fa-eye"></i>`);
                }
            });
        });
    </script>
</body>
</html>
