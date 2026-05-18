@extends('admin.layout.main')
@section('title', 'Admin - Prepaid Wallet')
@section('styles')
<link href="{{asset('public/admin/assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
<style>
    #reportrange{border: 1px solid grey;padding: 3px;width: fit-content;cursor: pointer;}
	#reportrange .fa-chevron-down{margin: 0 3px 0 3px;}
    .filter-form{margin-bottom: 10px;}
    .filter-form *{display: inline-block;}
    .filter-form select{height: 30px;}
</style>
@endsection
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Prepaid Wallet</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('admin.prepaid-wallet') }}">Home</a></li>
					<li class="breadcrumb-item active">Prepaid Wallet</li>
				</ol>
			</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="card-title">Prepaid Wallet</div>
                    <div class="card-tools">
                        @php($param_saprator = count($_GET) > 0 ? "&" : "?")
                        <a href="{{ Request::fullUrl() . $param_saprator }}download=true" class="btn btn-info btn-sm">Export</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="" method="get" class="filter-form">
                        <div id="reportrange">
                            <i class="fa fa-calendar"></i>
                            <span>{{date("F d, Y", strtotime($filter_from))}} - {{date("F d, Y", strtotime($filter_to))}}</span> <b class="caret"></b>
                            <input type="hidden" name="filter_from" id="filter_from" value="{{ $filter_from }}">
                            <input type="hidden" name="filter_to" id="filter_to" value="{{ $filter_to }}">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <button type="submit">Search</button>
                    </form>
                    <form action="{{ route('admin.makePaid') }}" method="post" id="make-wallet-paid-form">
                        @csrf
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" name="checkAll" id="checkAll">
                                    </th>
                                    <th>#</th>
                                    <th>Institute Name</th>
                                    <th>Student Name</th>
                                    <th>Wallet Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = $prepaid_wallet->firstItem())
                                @forelse($prepaid_wallet as $wallet)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="user_ids[]" class="user_ids" value="{{ $wallet->user_id }}">
                                    </td>
                                    <td>{{ $i }}</td>
                                    <td>{{ $wallet->institute_name }}</td>
                                    <td>{{ $wallet->user_name }}</td>
                                    <td>₹{{ $wallet->prepaid_wallet_amount }}</td>
                                </tr>
                                @php($i++)
                                @empty
                                <tr>
                                    <td colspan="12" class="text-center">No Wallet Found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <!-- <button type="button" class="btn btn-primary btn-sm make-paid-btn">Make Paid</button> -->
                    </form>
                    <div class="mt-3">
                        {{ $prepaid_wallet->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('public/admin/assets/plugins/daterange-picker/js/moment.min.js')}}"></script>
<script src="{{asset('public/admin/assets/plugins/daterange-picker/js/daterangepicker.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".prepaid-wallet-link").addClass('active');
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
        $(".make-paid-btn").on('click', function(){
            if ($('.user_ids:checked').length == 0) {
                alert("please select user first");
                return false;
            }
            if (confirm("Are you sure to make paid?")) {
                document.getElementById("make-wallet-paid-form").submit();
            }
        });
	});
</script>
@endsection