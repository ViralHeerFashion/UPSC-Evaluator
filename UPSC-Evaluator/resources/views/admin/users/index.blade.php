@extends('admin.layout.main')
@section('title', 'Admin - Students')
@section('styles')
<link href="{{asset('public/admin/assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
<style type="text/css">
	#reportrange{border: 1px solid grey;padding: 3px;width: fit-content;cursor: pointer;}
	#reportrange .fa-chevron-down{margin: 0 3px 0 3px;}
    #filter-form select{height: 30px;}
  	.qa-card {border-left: 4px solid #4a6fa5;transition: all 0.3s ease;margin-bottom: 1.5rem;}
    .qa-card:hover {box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);}
    .question {font-weight: 600;color: #2c3e50;margin-bottom: 0.5rem;}
    .answer {color: #555;line-height: 1.6;}
	.qa-container {max-height: 60vh;overflow-y: auto;padding-right: 10px;}
    .qa-container::-webkit-scrollbar {width: 6px;}
    .qa-container::-webkit-scrollbar-track {background: #f1f1f1;}
    .qa-container::-webkit-scrollbar-thumb {background: #c1c1c1;border-radius: 10px;}
    .qa-container::-webkit-scrollbar-thumb:hover {background: #a8a8a8;}
    .d-inline-block *{display: inline-block;}

	.wallet-summary-card{width:100%;background:linear-gradient(135deg,#ffffff,#f9f9ff);border-radius:18px;padding:5px;box-shadow:0 18px 45px rgba(0,0,0,0.1);}
    .wallet-title{font-size:18px;font-weight:700;color:#333;margin-bottom:5px;text-align:center;}
    .wallet-amount{text-align:center;margin-bottom:20px;border: 1px dashed grey;padding: 10px;border-radius: 10px;}
    .wallet-amount span{display:block;font-size:13px;color:#777;}
    .wallet-amount h2{margin:6px 0 0;font-size:34px;font-weight:800;color:#4a3aff;}
    .wallet-divider{height:1px;background:#e6e6e6;margin:18px 0;}
    .wallet-stats{display:grid;grid-template-columns:1fr 1fr;gap:14px;}
    .stat-box{background:#ffffff;border-radius:14px;padding:14px;text-align:center;box-shadow:0 8px 20px rgba(0,0,0,0.06);}
    .stat-box span{display:block;font-size:12px;color:#888;margin-bottom:4px;}
    .stat-box strong{font-size:18px;font-weight:700;color:#1e9c5b;}
    .per-student{grid-column:1 / 3;background:linear-gradient(135deg,#e8fff3,#ffffff);border:1px dashed #1e9c5b;}
    .per-student strong{font-size:22px;color:#1e9c5b;}
</style>
@endsection
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Students</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Home</a></li>
					<li class="breadcrumb-item active">Students</li>
				</ol>
			</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<form class="d-inline-block" id="filter-form">
					<input type="hidden" name="institute" value="{{@$_GET['institute']}}">
					<input type="hidden" name="life_time" value="{{@$_GET['life_time']}}">
					<div id="reportrange">
                        <i class="fa fa-calendar"></i>
                        <span>{{date("F d, Y", strtotime($filter_from))}} - {{date("F d, Y", strtotime($filter_to))}}</span> <b class="caret"></b>
                        <input type="hidden" name="filter_from" id="filter_from" value="{{ $filter_from }}">
                        <input type="hidden" name="filter_to" id="filter_to" value="{{ $filter_to }}">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <select name="is_registered" id="is_registered">
                        <option value="">Is Registered</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
					<select name="limit" id="limit">
						<option value="100">100</option>
						<option value="250">250</option>
						<option value="500">500</option>
						<option value="750">750</option>
						<option value="1000">1000</option>
						<option value="1500">1500</option>
						<option value="2000">2000</option>
						<option value="5000">5000</option>
					</select>
                    <input type="search" name="search" value="{{ @$_GET['search'] }}" placeholder="Search">
                    <button type="submit"><i class="fas fa-search"></i></button>
				</form>
			</div>
			<div class="card-body">
				@if($institute_wallet_amount > 0)
				<form action="{{ route('admin.institute.distributeRecharge', ['institute_uuid' => @$_GET['institute']]) }}" method="post" id="student_action_form">
					@csrf
				@endif
                <div class="table-responsive">
    				<table class="table table-striped table-bordered">
    					<thead>
    						<tr>
								@if($institute_wallet_amount > 0)
								<th class="text-center">
									<input type="checkbox" name="checkAll" id="checkAll">
								</th>
								@endif
    							<th>#</th>
    							<th>Date</th>
    							<th>Name</th>
    							<th>Phone</th>
    							<th>Email</th>
    							<th>Is Registerd</th>
    							<th>Question Attemp</th>
    						</tr>
    					</thead>
    					<tbody>
    						@php($i = $users->firstItem())
    						@foreach($users as $u)
    						<tr>
								@if($institute_wallet_amount > 0)
								<td class="text-center">
									<input type="checkbox" name="user_ids[]" value="{{$u->id}}" class="user_ids">
								</td>
								@endif
    							<td>{{ $i }}</td>
    							<td>{{ date("F d, Y h:i A", strtotime($u->created_at)) }}</td>
    							<td>{{ $u->name }}</td>
    							<td>{{ $u->phone }}</td>
    							<td>{{ $u->email }}</td>
    							<td>
    								@if($u->is_registered)
    								<span class="badge badge-success">Yes</span>
    								@else
    								<span class="badge badge-info">No</span>
    								@endif
    							</td>
    							<td>
    								@if($u->question_attempted_count)
    								<a href="javascript:void(0);" class="get-attempted-questions" data-user-id="{{ $u->id }}">
    									<i class="fas fa-eye fa-lg"></i>
    								</a>
    								@endif
    							</td>
    						</tr>
    						@php($i++)
    						@endforeach
    					</tbody>
    				</table>
                </div>
				@if($institute_wallet_amount > 0)
				<button type="button" class="btn btn-primary btn-sm make-recharge-btn"><i class="fas fa-paper-plane"></i>&nbsp; Make Recharge</button>
				</form>
				@endif
                {{ $users->links('pagination::bootstrap-5') }}
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="screening-question-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h3 class="modal-title fs-5">Screening Questions</h3>
			</div>
			<div class="modal-body question-container"></div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-sm close-modal" data-modal="#screening-question-modal" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="recharge-action-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title text-center fs-5" id="staticBackdropLabel">Recharge Detail</h3>
			</div>
			<div class="modal-body">
				<div class="wallet-summary-card">
					<div class="wallet-title">Wallet Summary</div>
					<div class="wallet-amount">
						<span>Total Wallet Amount</span>
						<h2 class="total-wallet-amount">₹{{number_format($institute_wallet_amount)}}</h2>
					</div>
					<div class="wallet-divider"></div>
					<div class="wallet-stats">
						<div class="stat-box">
							<span>Total Students</span>
							<strong class="total-students"></strong>
						</div>
						<div class="stat-box">
							<span>Total Recharges</span>
							<strong class="total-wallet-amount">₹{{number_format($institute_wallet_amount)}}</strong>
						</div>
						<div class="stat-box per-student">
							<span>Recharge Received Per Student</span>
							<strong class="per-student-amount"></strong>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-sm close-modal" data-modal="#recharge-action-modal" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info btn-sm make-recharge">Submit</button>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script src="{{asset('public/admin/assets/plugins/daterange-picker/js/moment.min.js')}}"></script>
<script src="{{asset('public/admin/assets/plugins/daterange-picker/js/daterangepicker.js')}}"></script>
<script type="text/javascript">
	var institute_wallet_amount = parseInt("{{$institute_wallet_amount}}");
	$(document).ready(function(){
		$(".users-link").addClass('active');
        $("#is_registered").val("{{ @$_GET['is_registered'] }}");
		$("#limit").val("{{$limit}}");
		$('#reportrange').daterangepicker({
            format: 'YYYY-MM-DD',
            showDropdowns: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            opens: "right",
            startDate: "{{date("Y-m-d", strtotime($filter_from))}}",
            endDate: "{{date("Y-m-d", strtotime($filter_to))}}",
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                'This Year': [moment().startOf('year'), moment().endOf('year')],
                'Life Time': [moment().subtract(50, 'year'), moment().endOf('year')]
            },
            drops: 'down',
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-primary',
            cancelClass: 'btn-default',
            separator: ' to ',
            locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Cancel',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                firstDay: 1
            }
        }, function(start, end, label) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            $("#filter_from").val(start.format('YYYY-MM-DD'));
            $("#filter_to").val(end.format('YYYY-MM-DD'));
        });
		$("#checkAll").on('click', function(){
			$(".user_ids").prop('checked', $(this).is(':checked'));
		});
		$(".make-recharge-btn").on('click', function(){
			let selected_students = parseInt($(".user_ids:checked").length);
			if (selected_students > 0) {
				$(".total-students").text(selected_students);
				$(".per-student-amount").text("₹"+(institute_wallet_amount/selected_students).toFixed(2));
				$("#recharge-action-modal").modal({
					backdrop: 'static'
				});
			} else {
				alert("Please select at least one student.");
			}
		});
		$(".make-recharge").on('click', function(){
			if (confirm("Are you sure to distribute recharge?")) {
				document.getElementById("student_action_form").submit();
			}
		});
        $(".get-attempted-questions").on('click', function () {
        	let user_id = $(this).data('user-id');
        	let _this = this;
        	let url = "{{ route('admin.users.attemtedQuestion', ['id' => ':id']) }}";
        	url = url.replace(':id', user_id);
        	$.ajax({
        		url: url,
        		method: "GET",
        		beforeSend: function () {
        			$(_this).html('<i class="fas fa-spinner fa-spin"></i>');
        		},
        		success: function(response){
        			$(_this).html('<i class="fas fa-eye fa-lg"></i>');
        			$(".question-container").html(response);
        			$("#screening-question-modal").modal('show');
        		}
        	})
        });
        $(".close-modal").on('click', function(){
        	let modal = $(this).data('modal');
        	$(modal).modal('hide');
        });
	});
</script>
@endsection