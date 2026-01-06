@extends('admin.layout.main')
@section('title', 'Institute - Security')
@section('styles')
<style>
    .error{color: maroon;font-weight: 400!important;}
</style>
@endsection
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Security</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Home</a></li>
					<li class="breadcrumb-item active">Security</li>
				</ol>
			</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Password Form</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('institute.profile.update') }}" method="post" id="profile-form">
                        @csrf
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>
                        <div class="float-right">
                            <button type="reset" class="btn btn-default btn-sm">Reset</button>
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('public/js/plugins/validate/jquery.validate.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $(".security-link").addClass('active');

        $("#profile-form").validate({
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
                password: {
                    minlength: "Password must be at least 8 characters long."
                },
                confirm_password: {
                    equalTo: "Confirm password is not match with password."
                }
            }
        });
    });
</script>
@endsection