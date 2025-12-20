@extends('admin.layout.main')
@section('title', 'Admin - Create new Institute')
@section('styles')
<style>
    .text-mute{color: grey;font-weight: 400;}
    .error{color: maroon;font-weight: 400!important;}
    .preview-image-element-container{position: relative;width: 190px;}
    .preview-image-element-container .delete-image{position: absolute;right: 0;}
</style>
@endsection
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Add new Institute</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ route('admin.institute') }}">Institute</a></li>
					<li class="breadcrumb-item active">Add/Edit</li>
				</ol>
			</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <form action="{{ route('admin.institute.create') }}" method="post" id="institute-form">
        @csrf
        @if(!is_null($institue))
        <input type="hidden" name="id" value="{{ $institue->id }}">
        @endif
        <div class="row">
            <div class="col-md-7">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="card-title">General Information</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" @if(!is_null($institue)) value="{{ $institue->name }}" @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="number" class="form-control" id="phone" name="phone" @if(!is_null($institue)) value="{{ $institue->phone }}" @endif>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" @if(!is_null($institue)) value="{{ $institue->email }}" @endif>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="card-title">Media</div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo <span class="text-mute">(Height: 60 or Width: Auto)</span></label>
                            <input type="file" class="form-control" id="logo-image" accept=".jpg, .jpeg, .png, image/jpeg, image/png">
                        </div>
                        <div class="preview-image-container">
                            <input type="hidden" name="logo" id="logo" @if(!is_null($institue) && Storage::disk('public')->exists($institue->logo)) value="{{ $institue->logo }}" @endif>
                            <div class="preview-image-element-container">
                                @if(!is_null($institue) && Storage::disk('public')->exists($institue->logo))
                                <a href='javascript:void(0);' class='delete-image' data-url='{{ $institue->logo }}'>
                                    <i class='fas fa-times'></i>
                                </a>
                                <img src='{{ Storage::disk("public")->url($institue->logo) }}' />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="card-title">Security</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right">
            <button type="reset" class="btn btn-default btn-sm">Reset</button>
            <button type="submit" class="btn btn-primary btn-sm">Save</button>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script src="{{asset('public/js/plugins/validate/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".institute-link").addClass('active');
        $("#institute-form").validate({
            rules: {
                name: {
                    required: true
                },
                phone: {
                    required: true,
                    minlength: 10,
                    maxlength: 10
                },
                email: {
                    required: true,
                    email: true
                },
                @if(is_null($institue))
                password: {
                    required: true
                },
                confirm_password: {
                    equalTo: "#password"
                }
                @endif
            },
            messages: {
                phone: {
                    minlength: "Please enter 10 digits phone number",
                    maxlength: "Please enter 10 digits phone number"
                },
                email: {
                    email: "Please enter valid email"
                },
                confirm_password: {
                    equalTo: "Confirm password is not match with password"
                }
            },
            submitHandler: function(form){
                if ($("#logo").val() == "") {
                    alert("Please upload a logo");
                    return false;
                }
                form.submit();
            }
        });
        $("#logo-image").on('change', function(){
            const file = this.files[0];
            if (!file) return;

            if (!file.type.startsWith('image/')) {
                alert('Please select a valid image');
                $(this).val('');
                return;
            }

            const img = new Image();
            const reader = new FileReader();

            reader.onload = function (e) {
                img.src = e.target.result;
            };

            img.onload = function () {

                if (img.height !== 60) {
                    alert('Image height must be exactly 60px');
                    $("#logo-image").val('');
                    input.value = '';
                    return;
                }

                let formData = new FormData();
                formData.append('logo', file);
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: '{{ route("admin.institute.uploadLogo") }}',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#result').html('Uploading...');
                    },
                    success: function (response) {
                        $("#logo").val(response.path);
                        $(".preview-image-element-container").html("<a href='javascript:void(0);' class='delete-image' data-url='"+response.path+"'><i class='fas fa-times'></i></a><img src='"+response.preview_path+"' />")
                    },
                    error: function () {
                        alert("Something went wrong please refresh page and try again");
                    }
                });
            };

            reader.readAsDataURL(file);
        });
        $(document).on('click', '.delete-image', function(){
            let url = $(this).data('url');
            $.ajax({
                url: "{{ route('admin.institute.deleteLogo') }}",
                method: "GET",
                data: {
                    url: url
                },
                success: function(){
                    $("#logo").val('');
                    $(".preview-image-element-container").html('');
                }
            })
        });
	});
</script>
@endsection