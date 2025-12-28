@extends('admin.layout.main')
@section('title', 'Institute - Students')
@section('styles')
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
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="card card-primary card-outline">
				<div class="card-header">
					<div class="card-title">
						<form action="" method="get">
							<input type="search" name="search" id="search" placeholder="Name/Phone/Email" value="{{ @$_GET['search'] }}">
							<button>Search</button>
						</form>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Eamil</th>
								<th>Unique code</th>
								<th>No of evalution</th>
							</tr>
						</thead>
						<tbody>
							@php($i = $students->firstItem())
							@foreach($students as $student)
							<tr>
								<td>{{$i}}</td>
								<td>{{$student->name}}</td>
								<td>{{$student->phone}}</td>
								<td>{{$student->email}}</td>
								<td>{{$student->unique_id}}</td>
								<td></td>
							</tr>
							@php($i++)
							@endforeach
						</tbody>
					</table>
					{{ $students->links('pagination::bootstrap-5') }}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
        $(".users-link").addClass('active');
    });
</script>
@endsection