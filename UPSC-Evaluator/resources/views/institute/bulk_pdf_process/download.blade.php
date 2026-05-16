@extends('admin.layout.main')
@section('title', 'Institute - Download PDF')
@section('styles')
<style>
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
									<a href="javascript:void(0);" class="btn btn-primary btn-sm download-all"><i class="fas fa-download"></i>&nbsp; Download ALL</a>
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
                                                    <th>Action</th>
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
                                                        @if($file->status == '1')
                                                        <a href="{{ Storage::disk('public')->url($file->success_file_path) }}" class="btn btn-primary btn-sm download-perticular-file w-100" target="_blank" download="Evaluation-{{ $file->file_name }}">Download</a>
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
<script>
    $(document).ready(function(){
        $(".bulk-pdf-process-link, .download-link").addClass('active');
		$('.batch-header').click(function(){
            var content = $(this).next('.batch-content');
            $('.batch-content').not(content).slideUp(200);
            content.slideToggle(200);
        });
        $(".download-all").on('click', function(event){
            event.stopPropagation();
            let file_path = [];
            $(this).parent().siblings('.batch-content').find('.download-perticular-file').each(function(){
                file_path.push($(this).attr('href'));
            });
            downloadFiles();
            function downloadFiles(index = 0){
                if(index >= file_path.length) return;
                var link = document.createElement('a');
                link.href = file_path[index];
                link.download = '';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                setTimeout(function(){
                    downloadFiles(index + 1);
                }, 300);
            }
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