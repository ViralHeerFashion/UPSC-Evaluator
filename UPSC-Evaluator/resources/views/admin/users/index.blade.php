@extends('admin.layout.main')
@section('title', 'Admin - Users')
@section('styles')
<link href="{{asset('admin/assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
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
</style>
@endsection
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Users</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Home</a></li>
					<li class="breadcrumb-item active">Users</li>
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
                    <input type="search" name="search" value="{{ @$_GET['search'] }}" placeholder="Search">
                    <button type="submit"><i class="fas fa-search"></i></button>
				</form>
			</div>
			<div class="card-body">
                <div class="table-responsive">
    				<table class="table table-striped table-bordered">
    					<thead>
    						<tr>
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
@endsection
@section('scripts')
<script src="{{asset('admin/assets/plugins/daterange-picker/js/moment.min.js')}}"></script>
<script src="{{asset('admin/assets/plugins/daterange-picker/js/daterangepicker.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".users-link").addClass('active');
        $("#is_registered").val("{{ @$_GET['is_registered'] }}");
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