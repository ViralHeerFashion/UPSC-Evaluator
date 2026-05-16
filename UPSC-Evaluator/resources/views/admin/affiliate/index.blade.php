@extends('admin.layout.main')
@section('title', 'Admin - Affiliate')
@section('styles')
<style>
</style>
@endsection
@section('content-header')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Affiliate</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="{{ route('admin.affiliate') }}">Home</a></li>
					<li class="breadcrumb-item active">Affiliate</li>
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
                    <div class="card-title">Affiliate</div>
                    <div class="card-tools">
                        <a href="javascript:void(0);" class="btn btn-info btn-sm add-new-affiliate">Add new Affiliate</a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Share Code</th>
                                <th>Student List</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i = $affiliates->firstItem())
                            @forelse($affiliates as $affiliate)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ date("d-m-Y h:i A", strtotime($affiliate->created_at)) }}</td>
                                <td>{{ $affiliate->name }}</td>
                                <td>{{ $affiliate->phone }}</td>
                                <td>{{ $affiliate->email }}</td>
                                <td>
                                    {{ $affiliate->affiliate_code }}
                                    <a href="javascript:void(0);"><i class="fa fa-clone copy-text" aria-hidden="true" data-text="{{ $affiliate->affiliate_code }}"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.users', ['life_time' => true, 'affiliate_id' => $affiliate->id]) }}" target="_blank">{{ $affiliate->students_count }}</a>
                                </td>
                                <td>
                                    <a href="javascript:void(0);" data-affiliate="{{ $affiliate }}" class="text-success edit-affiliate"><i class="far fa-edit"></i></a>
                                </td>
                                <td>
                                    <a href="{{ route('admin.affiliate.delete', ['id' => $affiliate->id]) }}" class="text-danger" onclick="return confirm('Are you sure do you want to delete this Affiliate?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @php($i++)
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">No Affiliates Found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $affiliates->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="affiliate-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <form action="{{ route('admin.affiliate.create') }}" method="post" id="affiliate_form">
        @csrf
        <input type="hidden" name="id" id="id">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5 text-center" id="staticBackdropLabel">Affiliate</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" aria-describedby="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" aria-describedby="phone" required maxlength="10" minlength="10">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" aria-describedby="email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="affiliate_code" class="form-label">Code</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="affiliate_code" id="affiliate_code" aria-label="affiliate_code" aria-describedby="button-addon2" required>
                                <button class="btn btn-outline-info generate-affiliate-code" type="button" id="button-addon2">Generate</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary close-modal" data-modal="affiliate-modal" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$(".affiliate-link").addClass('active');
        $(".add-new-affiliate").on('click', function(){
            document.getElementById("affiliate_form").reset();
            $("#affiliate-modal").modal({
                backdrop: 'static'
            });
        });
        $(".generate-affiliate-code").on('click', function(){
            $("#affiliate_code").val(share_code());
        });
        $(".edit-affiliate").on('click', function(){
            let affiliate = $(this).data('affiliate');
            $("#id").val(affiliate.id);
            $("#name").val(affiliate.name);
            $("#phone").val(affiliate.phone);
            $("#email").val(affiliate.email);
            $("#affiliate_code").val(affiliate.affiliate_code);
            $("#affiliate-modal").modal({
                backdrop: 'static'
            });
        });
        $(".close-modal").on('click', function(){
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
    function share_code(length = 5) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
</script>
@endsection