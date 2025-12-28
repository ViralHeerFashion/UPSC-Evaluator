@extends('admin.layout.main')
@section('title', 'Institute - Model Answer')
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
				<h1 class="m-0">Model Answer</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('institute.model-answer') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ route('institute.model-answer') }}">Model Answer</a></li>
					<li class="breadcrumb-item active">Add/Edit</li>
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
			<div class="card card-primary card-outline">
				<div class="card-header">
					<div class="card-title">
						Model Answer
					</div>
				</div>
				<div class="card-body">
                    <form action="{{ route('institute.model-answer.create') }}" method="post" id="model-answer-form" enctype='multipart/form-data'>
						@csrf
                        <div class="mb-3">
                            <label for="model_answer_pdf" class="form-label">Model Answer PDF</label>
                            <input type="file" class="form-control" id="model_answer_pdf" name="model_answer_pdf">
                        </div>
						<div class="text-right">
							<a href="{{ route('institute.model-answer') }}" class="btn btn-default btn-sm">Cancel</a>
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
        $(".model-answer-link").addClass('active');
		$.validator.addMethod("pdfFile", function (value, element) {
            if (element.files.length === 0) return false;

            const fileName = element.files[0].name.toLowerCase();
            return fileName.endsWith('.pdf');
        }, "Please upload only PDF file");
        $("#model-answer-form").validate({
            rules: {
                model_answer_pdf: {
                    required: true,
                    pdfFile: true
                }
            }
        });
    });
</script>
@endsection