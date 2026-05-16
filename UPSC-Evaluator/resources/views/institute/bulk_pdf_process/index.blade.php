@extends('admin.layout.main')
@section('title', 'Institute - Upload PDF')
@section('styles')
<style>
    .custom-file-upload {cursor: pointer;background: #f8f9fa;transition: all 0.3s ease;padding: 30px;border: 2px dashed #0d6efd;border-radius: 10px;text-align: center;font-size: 1.2rem;}
    .custom-file-upload:hover {background: #e9ecef;box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);}
    .file-text {font-weight: 500;color: #495057;font-size: 1.1rem;}
    .custom-file-upload i {transition: transform 0.3s ease;font-size: 40px;color: #0d6efd;margin-bottom: 10px;}
    .custom-file-upload:hover i {transform: scale(1.1);color: #0d6efd;}
    .file-selected {border-color: #28a745;background: #e7f1ff;}
    .file-selected i {color: #28a745;}
    .custom-file-upload {position: relative;cursor: pointer;background: #f8f9fa;transition: all 0.3s ease;padding: 30px;border: 2px dashed #0d6efd;border-radius: 10px;text-align: center;font-size: 1.2rem;}
    #pdf_files{position:absolute;left:0;top:0;width:100%;height:100%;opacity:0;cursor:pointer;}
    .upload-error{background-color: #ffb1b1!important;}
    .uploaded-history tbody {display: block;max-height: 300px;overflow-y: auto;}
    .uploaded-history thead, .uploaded-history tbody tr {display: table;width: 100%;table-layout: fixed;}
    .uploaded-history thead {width: calc(100% - 8px);}
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
		<div class="col-md-6">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<div class="card-title">
						Upload Files
					</div>
				</div>
				<div class="card-body">
                    <form action="" id="batch_form">
                        <div class="mb-3">
                            <label for="language_id" class="form-label">Language</label>
                            <select name="language_id" id="language_id" class="form-control">
                                @foreach($languages as $l)
                                <option value="{{ $l->id }}">{{ $l->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">PDF Files</label>
                            <div class="custom-file-upload">
                                <input type="file" id="pdf_files" name="pdf_files[]" multiple accept=".pdf">
                                <div class="file-text">
                                    <i class="fas fa-cloud-upload-alt"></i><br>
                                    Click to Upload or drag & drop
                                </div>
                                <div class="invalid-feedback mt-2">Please select a file.</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('institute.bulk-pdf-process') }}" class="btn btn-default btn-sm">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-sm submit-btn">Submit</button>
                        </div>
                    </form>
				</div>
			</div>
		</div>
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="card-title">Progress</div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-bordered uploaded-history">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>File Name</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $(".bulk-pdf-process-link, .upload-link").addClass('active');
        let institute_upload_batch_id = null;
        $(document).on("change", "#pdf_files", function(){
            let files = this.files;
            if(files.length === 0){
                $(".file-text").html('<i class="fas fa-cloud-upload-alt"></i><br>Click to Upload or drag & drop');
                $(".custom-file-upload").removeClass("file-selected");
                return;
            }
            let count = files.length;
            $(".file-text").html(
                '<i class="fas fa-file-pdf"></i><br>' + count + ' file' + (count > 1 ? 's' : '') + ' selected'
            );
            $(".custom-file-upload").addClass("file-selected");
        });
        $("#batch_form").on("submit", function(e){
            e.preventDefault();
            let files = $("#pdf_files")[0].files;
            if(files.length == 0){
                alert("Please select PDF files");
                return;
            }
            uploadFile(files, 0);
        });

        function uploadFile(files, index){
            if(index >= files.length){
                $("#pdf_files").val('');
                $(".file-text").html(`
                    <i class="fas fa-cloud-upload-alt"></i><br>
                    Click to Upload or drag & drop
                `);
                $(".submit-btn").attr('disabled', false);
                return;
            }

            $(".submit-btn").attr('disabled', true);

            let file = files[index];

            if(file.type !== "application/pdf"){
                $(".uploaded-history tbody").append("<tr class='upload-error'><td>"+(index + 1)+"</td><td>"+file.name+"</td><td>Upload failed. Please upload a valid PDF file.</td></tr>");
                uploadFile(files, index + 1);
                return;
            }

            let formData = new FormData();
            formData.append("pdf_file", file);
            formData.append("_token", "{{ csrf_token() }}");
            formData.append('language_id', $("#language_id").val());

            if(institute_upload_batch_id !== null){
                formData.append("institute_upload_batch_id", institute_upload_batch_id);
            }            

            $.ajax({
                url: "{{ route('institute.bulk-pdf-process.uploadFiles') }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){

                    if(institute_upload_batch_id === null && response.institute_upload_batch_id){
                        institute_upload_batch_id = response.institute_upload_batch_id;
                    }
                    if (response.success) {
                        $(".uploaded-history tbody").append("<tr><td>"+(index + 1)+"</td><td>"+file.name+"</td><td>File Uploaded successfully...</td></tr>");                        
                    } else {
                        $(".uploaded-history tbody").append("<tr class='upload-error'><td>"+(index + 1)+"</td><td>"+file.name+"</td><td>"+response.message+"</td></tr>");                        
                    }

                    uploadFile(files, index + 1);
                },
                error: function(){

                    $(".uploaded-history tbody").append("<tr class='upload-error'><td>"+(index + 1)+"</td><td>"+file.name+"</td><td>Error uploading</td></tr>");

                    uploadFile(files, index + 1);
                }
            });
        }
    });
</script>
@endsection