@extends('admin.layout.main')
@section('title', 'Institute - Model Answer')
@section('styles')
<style>
    .error{color: maroon;font-weight: 400!important;}
	#page-loader{position:fixed;inset:0;background:#fff;z-index:999999;display:flex;align-items:center;justify-content:center;opacity:0;visibility:hidden;transition:.35s ease;}
	#page-loader.active{opacity:1;visibility:visible;}
	.loader-wrapper{text-align:center;}
	.ring{width:70px;height:70px;border-radius:50%;border:6px solid #f1f1f1;border-top-color:#e82954;animation:spin .8s linear infinite;margin:0 auto 18px;}
	@keyframes spin{to{transform:rotate(360deg)}}
	.loader-text{font-size:17px;font-weight:600;color:#222;}
	.loader-subtext{font-size:13px;color:#777;margin-top:6px;}
	.progress{height:4px;background:#f1f1f1;border-radius:6px;margin-top:16px;overflow:hidden;}
	.progress span{display:block;height:100%;background:#e82954;animation:load 2s infinite;}
	@keyframes load{0%{width:0}50%{width:70%}100%{width:100%}}
	.loader-timer{margin-top:14px;font-size:22px;font-weight:700;letter-spacing:1px;color:#e82954;}
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
<div id="page-loader">
    <div class="loader-wrapper">
        <div class="ring"></div>
        <div class="loader-text">Please wait…</div>
        <div class="loader-subtext">Processing your request</div>
		  <div class="loader-timer">
            <span id="loader-min">07</span>:<span id="loader-sec">00</span>
        </div>
        <div class="progress"><span></span></div>
    </div>
</div>
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
                    <form id="model-answer-form">
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
		var url = "{{ route('institute.model-answer.create') }}";
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
            },
            submitHandler: function(form){
				$.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var file = $("#model_answer_pdf")[0].files[0];
                var formData = new FormData();
                formData.append('model_answer_pdf', file);
                formData.append('_token', '{{ csrf_token() }}');
                ajaxInProgress = true;
				$.ajax({
                    url: url,
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function(){
						$('#page-loader').addClass('active');

						if (countdownInterval) {
							clearInterval(countdownInterval);
						}

						startLoaderTimer(LOADER_MINUTES);
                    }
                }).then(function(response) {

                    ajaxInProgress = true;
                    if (response.success) {
                        let task_id = response.task_id;

                        function processTask(task_id, retries = 0, maxRetries = 50000) {
                            ajaxInProgress = true;
                            let process_url = "{{ route('institute.model-answer.processTask', ':task_id') }}".replace(':task_id', task_id);

                            return $.ajax({
                                url: process_url,
                                type: "GET",
                                data: { _token: '{{ csrf_token() }}' },
                                processData: false,
                                contentType: false
                            }).then(function (response) {
                                if (response.success) {
                                    ajaxInProgress = false;
                                    toastr.success(response.message, 'Success');
									$('#page-loader').removeClass('active');
									window.location.href = response.redirect_url;
                                } else if ('process_task' in response) {
                                    if (retries < maxRetries) {
                                        return new Promise((resolve) => {
                                            setTimeout(() => {
                                                resolve(processTask(task_id, retries + 1, maxRetries));
                                            }, 5000);
                                        });
                                    } else {
                                        ajaxInProgress = false;
										$('#page-loader').removeClass('active');
                                        toastr.error("Max retries reached. Please try again later.", 'Error');
                                    }
                                } else {
                                    ajaxInProgress = false;
									$('#page-loader').removeClass('active');
                                    toastr.error("Something went wrong, please contact our support team.", 'Error');
                                }
                            }).fail(function () {
                                ajaxInProgress = false;
								$('#page-loader').removeClass('active');
                                toastr.error("Something went wrong, please support our team.", 'Error');
                            });
                        }

                        processTask(task_id);
                    } else {
                        ajaxInProgress = false;
                        if("server_busy" in response) {
                            toastr.info(response.message, 'Info');
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                        return $.Deferred().resolve().promise();
                    }

                }).fail(function(err) {
                    ajaxInProgress = false;
					$('#page-loader').removeClass('active');
                    toastr.error("Something went wrong please support our team.", 'Error');
                });

				return false;
			}
        });
    });

	let LOADER_MINUTES = 10; // ⬅️ change this value
	let countdownInterval = null;

	function startLoaderTimer(minutes){
		let totalSeconds = minutes * 60;

		updateTimerUI(totalSeconds);

		countdownInterval = setInterval(() => {
			totalSeconds--;

			if (totalSeconds <= 0) {
				clearInterval(countdownInterval);
				updateTimerUI(0);
				return;
			}

			updateTimerUI(totalSeconds);
		}, 1000);
	}

	function updateTimerUI(seconds){
		const min = String(Math.floor(seconds / 60)).padStart(2, '0');
		const sec = String(seconds % 60).padStart(2, '0');

		document.getElementById('loader-min').textContent = min;
		document.getElementById('loader-sec').textContent = sec;
	}

</script>
@endsection