@extends('admin.layout.main')
@section('title', 'Admin - Student Answer Sheet')
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
				<h1 class="m-0">Institute</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('admin.institute') }}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{ route('admin.institute') }}">Institute</a></li>
					<li class="breadcrumb-item active">Student Sheet</li>
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
                    <div class="card-title">Student Sheet</div>
                    <div class="card-tools">
                        <a href="" class="btn btn-dark btn-sm">Download Sample File</a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                    <div class="mb-3">
                        <div class="alert alert-danger" role="alert">
                            Error: Your whole sheet is not import please check below errors!
                        </div>
                        <table class="table table-bordered table-danger">
                            <thead>
                                <tr>
                                    <th>Row Number</th>
                                    <th>Field</th>
                                    <th>Error</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (collect(json_decode($errors->all()[0]))->sortKeys() as $row => $errors)
                                    @php($j = 1)
                                    @foreach($errors as $error_column => $error)
                                    <tr>
                                        @if($j == 1)
                                        <td rowspan="{{ count((array) $errors) }}">{{$row}}</td>
                                        @endif
                                        <td>{{$error_column}}</td>
                                        <td>{{$error[0]}}</td>
                                    </tr>
                                    @php($j++)
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    <form action="{{ route('admin.institute.uploadSheet', ['institute_id' => $institue->id]) }}" method="post" id="student-sheet-form" enctype='multipart/form-data'>
                        @csrf
                        <div class="mb-3">
                            <label for="student_sheet" class="form-label">Student Sheet</label>
                            <input type="file" class="form-control" id="student_sheet" name="student_sheet" accept=".xls, .xlsx">
                        </div>
                        <div class="text-right">
                            <a href="{{ route('admin.institute') }}" class="btn btn-default btn-sm">Cancel</a>
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-upload"></i> Upload</button>
                        </div>
                    </form>

                    @if($student_sheets->count() > 0)
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Sheet</th>
                                <th>Total Students</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <a href="{{ route('admin.users', ['life_time' => true, 'institute' => $institue->uuid, 'limit' => 5000]) }}">ALL</a>
                                </td>
                                <td>{{$total_students}}</td>
                            </tr>
                            @php($i = 1)
                            @foreach($student_sheets as $sheet)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{date("d-m-Y h:i A", strtotime($sheet->created_at))}}</td>
                                <td>
                                    <a href="{{ route('admin.users', ['life_time' => true, 'institute' => $institue->uuid, 'sheet_id' => $sheet->id, 'limit' => 5000]) }}">{{$sheet->sheet_name}}</a>
                                </td>
                                <td>{{$sheet->users_count}}</td>
                            </tr>
                            @php($i++)
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset('public/js/plugins/validate/jquery.validate.min.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(".institute-link").addClass('active');
        $.validator.addMethod("excelFile", function (value, element) {
            if (element.files.length === 0) return false;

            const fileName = element.files[0].name.toLowerCase();
            return fileName.endsWith('.xls') || fileName.endsWith('.xlsx');
        }, "Please upload only Excel file (.xls or .xlsx)");
        $("#student-sheet-form").validate({
            rules: {
                student_sheet: {
                    required: true,
                    excelFile: true
                }
            },
            messages: {
                student_sheet: {
                    accept: "Please upload only Excel file (.xls or .xlsx)"
                }
            }
        });
	});
</script>
@endsection