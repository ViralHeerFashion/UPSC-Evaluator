@extends('admin.layout.main')
@section('title', 'Admin - Bulk PDF Process')
@section('styles')
<link href="{{asset('public/admin/assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
<style>
    #reportrange{border: 1px solid grey;padding: 3px;width: fit-content;cursor: pointer;}
	#reportrange .fa-chevron-down{margin: 0 3px 0 3px;}
    .filter-form *{display: inline-block;}
    .filter-form select{height: 30px;}
</style>
@endsection
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Bulk PDF Process</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
					<li class="breadcrumb-item active">Bulk PDF Process</li>
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
                    <div class="card-title">Bulk PDF Process</div>
                    <div class="card-tools">
                        @php($param_saprator = count($_GET) > 0 ? "&" : "?")
                        <a href="{{ Request::fullUrl() . $param_saprator }}download=true" class="btn btn-info btn-sm"><i class="fas fa-download"></i>&nbsp;Export</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <form action="" method="get" class="filter-form">
                            <div id="reportrange">
                                <i class="fa fa-calendar"></i>
                                <span>{{date("F d, Y", strtotime($filter_from))}} - {{date("F d, Y", strtotime($filter_to))}}</span> <b class="caret"></b>
                                <input type="hidden" name="filter_from" id="filter_from" value="{{ $filter_from }}">
                                <input type="hidden" name="filter_to" id="filter_to" value="{{ $filter_to }}">
                                <i class="fas fa-chevron-down"></i>
                            </div>
                            <select name="institute_id" id="institute_id">
                                <option value="">Institute</option>
                                @foreach($institutes as $insitute)
                                <option value="{{ $insitute->id }}">{{ $insitute->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit">Search</button>
                        </form>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Institute</th>
                                <th>Batch</th>
                                <th>File Name</th>
                                <th>No of Pages</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = $institute_upload_files->firstItem())
                            @forelse($institute_upload_files as $file)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $file->upload_batch->institute->name }}</td>
                                <td>{{ date("d-m-Y h:i A", strtotime($file->upload_batch->created_at)) }}</td>
                                <td>
                                    {{ $file->file_name }}
                                </td>
                                <td>{{ $file->no_of_pages }}</td>
                            </tr>
                            @php($i++)
                            @empty
                            <tr>
                                <td colspan="12" class="text-center">No File Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $institute_upload_files->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
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
		$(".bulk-pdf-process-link").addClass('active');
        $("#institute_id").val("{{ @$_GET['institute_id'] }}");
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
	});
</script>
@endsection