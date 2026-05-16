@extends('admin.layout.main')
@section('title', 'History - Download PDF')
@section('styles')
<link href="{{asset('public/admin/assets/plugins/daterange-picker/css/daterangepicker-bs3.css')}}" rel="stylesheet">
<style>
    #reportrange{border: 1px solid grey;padding: 3px;width: fit-content;cursor: pointer;}
    #reportrange .fa-chevron-down{margin: 0 3px 0 3px;}
    .filter-form *{display: inline-block;}
    .filter-form select{height: 30px;}
    .batch-card{background:#ffffff;border-radius:10px;margin-bottom:18px;border:1px solid #e6e9ef;transition:all .25s ease;}
    .batch-card:hover{box-shadow:0 6px 20px rgba(0,0,0,0.05);}
    .batch-header{padding:18px 20px;display:flex;flex-wrap:wrap;align-items:center;gap:15px;cursor:pointer;}
    .batch-title{font-weight:600;color:#34495e;}
    .badge{font-size:12px;font-weight:500;padding:5px 10px;border-radius:20px;}
    .badge-success{background:#e6f7ef;color:#1e874b;}
    .badge-failed{background:#fdeaea;color:#d64545;}
    .pages{color:#3b82f6;font-weight:600;}
    .batch-content{display:none;border-top:1px solid #eef1f6;}
    .download-btn:hover{background:#16a34a;}
    @media(max-width:768px){
        .batch-header{flex-direction:column;align-items:flex-start;}
        .download-all{margin-left:0;}
    }
    pre{background:#f6f8fa;padding:10px;border-radius:6px;font-size:13px;max-height:300px;overflow:auto;}
    .batch-content{height: 300px;overflow-y: scroll;}
</style>
@endsection
@section('content-header')
<div class="content-header">
    @include('institute.bulk_pdf_process.partials.tabs')
</div>
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<div class="card-title">
						Proccesed Batches Files
					</div>
				</div>
				<div class="card-body">     
					<div class="row">
                        <div class="col-md-12 mb-3">
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
                        </div>
						@foreach($institute_upload_batch as $batch)
						<div class="col-md-4">
							<div class="batch-card">
								<div class="batch-header">
									<span class="batch-title">📅 {{ date("d M Y • h:i A", strtotime($batch->created_at)) }}</span>
									<span class="badge badge-success">✔ Success {{ $batch->success_count }}</span>
                                    @if($batch->fail_count)
                                    <span class="badge badge-failed">✖ Failed {{ $batch->fail_count }}</span>
                                    @endif
									<span class="pages">📄 {{ $batch->total_pages }} Pages</span>
								</div>
								<div class="batch-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>File Name</th>
                                                    <th>Pages</th>
                                                    <th>Status</th>
                                                    <th>Fail Response</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php($i = 1)
                                                @foreach($batch->files as $file)
                                                <tr>
                                                    <td>{{ $i }}</td>
                                                    <td>{{ $file->file_name }}</td>
                                                    <td>{{ $file->no_of_pages }}</td>
                                                    <td>
                                                        @if($file->status == '1')
                                                        <span class="badge-success">Success</span>
                                                        @elseif($file->status == '0')
                                                        <span class="badge-danger">Failed</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($file->status == '2' && !is_null($file->api_response))
                                                        <div class="json-data">{!! $file->api_response !!}</div>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @php($i++)
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
								</div>
							</div>
						</div>
						@endforeach
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
<script>
    $(document).ready(function(){
        $(".bulk-pdf-process-link, .history-link").addClass('active');
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
		$('.batch-header').click(function(){
            var content = $(this).next('.batch-content');
            $('.batch-content').not(content).slideUp(200);
            content.slideToggle(200);
        });
        $('.json-data').each(function () {
            try {
                var jsonString = $(this).text().trim();
                var jsonObj = JSON.parse(jsonString);
                var pretty = JSON.stringify(jsonObj, null, 4);
                $(this).html('<pre style="margin:0;">' + pretty + '</pre>');
            } catch (e) {
                console.log('Invalid JSON');
            }
        });
    });
</script>
@endsection