@extends('student.template.main')
@section('title', 'Security')
@section('style')
<style>
    .contact-details-box{padding: 25px!important;}
    .error{color: #cb2c2c;}
</style>
@endsection
@section('tab-name')
<div class="banner-area">
    <div class="settings-area">
        <h3 class="title">Security</h3>
        @include('student.profile.partials.nav')
    </div>
</div>
@endsection
@section('content')
<div class="contact-details-box">
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <form action="{{ route('student.profile.update-password') }}" method="post" id="password-form">
        @csrf
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="" value="">
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" placeholder="" value="">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group">
                <button type="submit" class="btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $(".security").addClass('active');
        $("#password-form").validate({
            rules: {
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
                confirm_password: {
                    equalTo: "Confirm password is not match with password"
                }
            }
        });
    });
</script>
@endsection