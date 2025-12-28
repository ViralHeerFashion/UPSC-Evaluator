@extends('admin.layout.main')
@section('title', 'Institute - Model Answer')
@section('styles')
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
					<li class="breadcrumb-item active">Model Answer</li>
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
					<div class="card-title">
						Model Answer
					</div>
                    <div class="card-tools">
                        <a href="{{ route('institute.model-answer.add') }}" class="btn btn-sm btn-info">Add new model answer</a>
                    </div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Date</th>
								<th>File Name</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
							@php($i = $model_answers->firstItem())
							@forelse($model_answers as $model_answer)
							<tr>
								<td>{{$i}}</td>
								<td>{{ date("d-m-Y h:i A", strtotime($model_answer->created_at)) }}</td>
								<td>
                                    <a href="{{ route('institute.model-answer.view', ['id' => $model_answer->id]) }}">{{ $model_answer->file_name }}</a>
                                </td>
								<td>
									<a href="{{ route('institute.model-answer.delete', ['id' => $model_answer->id]) }}" class="text-danger" onclick="return confirm('Are you sure to delete this model answer?')"><i class="fas fa-trash"></i></a>
								</td>
							</tr>
							@php($i++)
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">No Model Answer Found</td>
                            </tr>
							@endforelse
						</tbody>
					</table>
					{{ $model_answers->links('pagination::bootstrap-5') }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $(".model-answer-link").addClass('active');
    });
</script>
@endsection