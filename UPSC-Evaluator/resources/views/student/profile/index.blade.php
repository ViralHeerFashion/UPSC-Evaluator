@extends('student.template.main')
@section('title', 'Profile')
@section('style')
<style>
    .contact-details-box{padding: 25px!important;}
    .error{color: #cb2c2c;}
</style>
@endsection
@section('tab-name')
<div class="banner-area">
    <div class="settings-area">
        <h3 class="title">Profile</h3>
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
    <form action="{{ route('student.profile.update') }}" method="post" id="profile-form">
        @csrf
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter your Name" value="{{ auth()->user()->name }}">
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="phone">Phone (It's not editable)</label>
                <input type="number" name="phone" id="phone" value="{{ auth()->user()->phone }}" readonly>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" id="email" placeholder="Enter your Email" value="{{ auth()->user()->email }}">
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
        $(".profile").addClass('active');
        $("#profile-form").validate({
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true,
                    remote: {
                        url: "{{route('student.profile.check-email')}}",
                        type: "GET",
                        data: {
                            email: function() {
                                return $('#email').val();
                            }
                        }
                    }
                }
            },
            messages: {
                email: {
                    remote: "This email is already exists!"
                }
            }
        });
    });
</script>
@endsection