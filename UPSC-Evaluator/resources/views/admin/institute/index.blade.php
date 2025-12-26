@extends('admin.layout.main')
@section('title', 'Admin - Institute')
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
                                <td>{{ $institute->phone }}</td>
                                <td>{{ $institute->email }}</td>
                                <td>
                                    <a href="javascript:void(0);">{{ substr(route('student.login', ['institute' => $institute->uuid]), 0, 35) }}...</a>
                                    <a href="javascript:void(0);"><i class="fa fa-clone copy-text" aria-hidden="true" data-text="{{ route('admin.institute.studentSheet', ['uuid' => $institute->uuid]) }}"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.institute.studentSheet', ['uuid' => $institute->uuid]) }}"><i class="far fa-file-excel fa-2x"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.institute.recharge', ['uuid' => $institute->uuid]) }}"><i class="fab fa-uncharted fa-2x"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.institute.add', ['uuid' => $institute->uuid]) }}" class="text-success"><i class="far fa-edit"></i></a>
                                </td>
                                <td>
                                    <a href="" class="text-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @php($i++)
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No Institute Found</td>
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
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(".institute-link").addClass('active');
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