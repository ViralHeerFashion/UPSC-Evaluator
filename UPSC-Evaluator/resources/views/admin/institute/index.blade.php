@extends('admin.layout.main')
@section('title', 'Admin - Institute')
@section('styles')
<style>
    .excel-sheet{color: #1D6F42!important;}
    .money-icon{color: #97831b!important;}
    .cl-toggle-switch {position: relative;}
    .cl-switch {position: relative;display: inline-block;}
    .cl-switch > input {appearance: none;-moz-appearance: none;-webkit-appearance: none;z-index: -1;position: absolute;right: 6px;top: -8px;display: block;margin: 0;border-radius: 50%;width: 40px;height: 40px;background-color: rgb(0, 0, 0, 0.38);outline: none;opacity: 0;transform: scale(1);pointer-events: none;transition: opacity 0.3s 0.1s, transform 0.2s 0.1s;}
    .cl-switch > span::before {content: "";float: right;display: inline-block;margin: 5px 0 5px 10px;border-radius: 7px;width: 36px;height: 14px;background-color: rgb(0, 0, 0, 0.38);vertical-align: top;transition: background-color 0.2s, opacity 0.2s;}
    .cl-switch > span::after {content: "";position: absolute;top: 2px;right: 16px;border-radius: 50%;width: 20px;height: 20px;background-color: #fff;box-shadow: 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 1px 5px 0 rgba(0, 0, 0, 0.12);transition: background-color 0.2s, transform 0.2s;}
    .cl-switch > input:checked {right: -10px;background-color: #85b8b7;}
    .cl-switch > input:checked + span::before {background-color: #85b8b7;}
    .cl-switch > input:checked + span::after {background-color: #018786;transform: translateX(16px);}
    .cl-switch:hover > input {opacity: 0.04;}
    .cl-switch > input:focus {opacity: 0.12;}
    .cl-switch:hover > input:focus {opacity: 0.16;}
    .cl-switch > input:active {opacity: 1;transform: scale(0);transition: transform 0s, opacity 0s;}
    .cl-switch > input:active + span::before {background-color: #8f8f8f;}
    .cl-switch > input:checked:active + span::before {background-color: #85b8b7;}
    .cl-switch > input:disabled {opacity: 0;}
    .cl-switch > input:disabled + span::before {background-color: #ddd;}
    .cl-switch > input:checked:disabled + span::before {background-color: #bfdbda;}
    .cl-switch > input:checked:disabled + span::after {background-color: #61b5b4;}
</style>
@endsection
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Institute</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('admin.institute') }}">Home</a></li>
					<li class="breadcrumb-item active">Institute</li>
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
                    <div class="card-title">Institute</div>
                    <div class="card-tools">
                        <a href="{{route('admin.institute.add')}}" class="btn btn-info btn-sm">Add new Institute</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Logo</th>
                                <th>Name</th>
                                <th>API Name</th>
                                <th>Settings</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Student Sheet</th>
                                <th>Recharge</th>
                                <th>Login Link</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = $institutes->firstItem())
                            @forelse($institutes as $institute)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ date("d-m-Y h:i A", strtotime($institute->created_at)) }}</td>
                                <td>
                                    @if(!empty($institute->logo) && Storage::disk('public')->exists($institute->logo))
                                    <img src="{{ Storage::disk('public')->url($institute->logo) }}">
                                    @endif
                                </td>
                                <td>{{ $institute->name }}</td>
                                <td>{{ $institute->institute_api_name }}</td>
                                <td class="text-center">
                                    <a href="javascript:void(0);" class="edit-permission" data-permission="{{ $institute->permissions }}" data-institute-id="{{ $institute->id }}"><i class="fas fa-cog fa-lg"></i></a>
                                </td>
                                <td>{{ $institute->phone }}</td>
                                <td>{{ $institute->email }}</td>
                                <td>
                                    <a href="{{ route('admin.institute.studentSheet', ['uuid' => $institute->uuid]) }}" class="excel-sheet"><i class="far fa-file-excel fa-2x"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.institute.recharge', ['uuid' => $institute->uuid]) }}" class="money-icon"><i class="fas fa-money-bill-alt fa-2x"></i></a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);">{{ substr(route('student.login', ['institute' => $institute->uuid]), 0, 35) }}...</a>
                                    <a href="javascript:void(0);"><i class="fa fa-clone copy-text" aria-hidden="true" data-text="{{ route('student.login', ['institute' => $institute->uuid]) }}"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.institute.add', ['uuid' => $institute->uuid]) }}" class="text-success"><i class="far fa-edit"></i></a>
                                </td>
                                <td>
                                    @if(!$institute->students_exists)
                                    <a href="{{ route('admin.institute.delete', ['institute_id' => $institute->id]) }}" class="text-danger" onclick="return confirm('Are you sure do you want to delete this institute?')"><i class="fas fa-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @php($i++)
                            @empty
                            <tr>
                                <td colspan="12" class="text-center">No Institute Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $institutes->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="permission-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form action="{{ route('admin.institute.featurePermission') }}" method="post">
        @csrf
        <input type="hidden" name="institute_id" id="institute_id">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5 text-center" id="staticBackdropLabel">Permissions</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Permission</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Bulk PDF Process</td>
                                <td>
                                    <div class="cl-toggle-switch">
                                        <label class="cl-switch">
                                            <input type="checkbox" class="features-switch bulk_pdf_process" name="features[]" value="bulk_pdf_process">
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Students</td>
                                <td>
                                    <div class="cl-toggle-switch">
                                        <label class="cl-switch">
                                            <input type="checkbox" class="features-switch students" name="features[]" value="students">
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Model Answer</td>
                                <td>
                                    <div class="cl-toggle-switch">
                                        <label class="cl-switch">
                                            <input type="checkbox" class="features-switch model_answer" name="features[]" value="model_answer">
                                            <span></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm close-modal" data-modal="permission-modal" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(".institute-link").addClass('active');
        $(".edit-permission").on('click', function(){
            let permissions = $(this).data('permission');
            let institute_id = $(this).data('institute-id');
            $(".features-switch").attr('checked', false);
            $("#institute_id").val(institute_id);
            if (permissions != "") {
                $.each(permissions, function(key, value){
                    $("."+value).attr('checked', true);
                });   
            }            
            $("#permission-modal").modal('show');
        });
        $(".close-modal").click(function(){
            $("#"+$(this).data('modal')).modal('hide');
        });
        $(document).on("click", ".copy-text", function () {
            let text = $(this).data('text');
            let _this = this;
            $('.fa-check').addClass('fa-clone');
            $(_this).removeClass('fa-check');
            const textArea = document.createElement("textarea");
            textArea.value = text;
            $(this).append(textArea);
            textArea.focus();
            textArea.select();
            try {
                document.execCommand('copy');
            } catch (err) {
                console.error('Unable to copy to clipboard', err);
            }
            textArea.remove();
            $(this).removeClass('fa-clone');
            $(this).addClass('fa-check');
            setTimeout(
            function() {
                $(_this).addClass('fa-clone');
                $(_this).removeClass('fa-check');
            }, 1000);
        });
	});
</script>
@endsection