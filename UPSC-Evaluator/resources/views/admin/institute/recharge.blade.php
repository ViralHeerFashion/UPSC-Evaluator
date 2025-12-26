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
					<li class="breadcrumb-item active">Recharge</li>
				</ol>
			</div>
        </div>
    </div>
</div>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="card-title">Recharge</div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.institute.makeRecharge', ['uuid' => $uuid]) }}" method="post" id="recharge-form">
                        @csrf
                        @if(!is_null($recharge))
                        <input type="hidden" name="id" value="{{ $recharge->id }}">
                        @endif
                        <div class="mb-3">
                            <label for="order_no" class="form-label">Order No</label>
                            <div class="input-group">
                                <input type="text" class="form-control order-no" placeholder="Order no" name="order_no" id="order_no" @if(!is_null($recharge)) value="{{ $recharge->order_id }}" @endif>
                                <button class="btn btn-outline-primary generate-order-no" type="button">Generate</button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" @if(!is_null($recharge)) value="{{ $recharge->amount }}" @endif>
                        </div>
                        <div class="mb-3">
                            <label for="payment_proof" class="form-label">Payment Proof</label>
                            <textarea name="payment_proof" id="payment_proof" class="form-control" rows="3">@if(!is_null($recharge)){{ $recharge->razorpay_order_id }}@endif</textarea>
                        </div>
                        <div class="text-right">
                            <a href="{{ route('admin.institute.recharge', ['uuid' => $uuid]) }}" class="btn btn-default btn-sm">Cancel</a>
                            <button type="submit" class="btn btn-info btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="card-title">Wallet</div>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Order Id</th>
                                <th>Amount</th>
                                <th>Payment Proof</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php($i=1)
                            @forelse($wallets as $w)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{date("d-m-Y h:i A", strtotime($w->created_at))}}</td>
                                <td>{{ !is_null($w->recharge) ? $w->recharge->order_id : "" }}</td>
                                <td>₹{{ number_format($w->amount) }}</td>
                                <td>{{ !is_null($w->recharge) ? $w->recharge->razorpay_order_id : "" }}</td>
                                <td>
                                    @if(!is_null($w->recharge))
                                    <a href="{{ route('admin.institute.recharge', ['uuid' => $uuid, 'id' => $w->recharge_id]) }}" class="text-success"><i class="far fa-edit"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if(!is_null($w->recharge))
                                    <a href="{{ route('admin.institute.deleteRecharge', ['uuid' => $uuid, 'id' => $w->recharge_id]) }}" class="text-danger" onclick="return confirm('Are you sure to delete this recharge?')"><i class="fas fa-trash"></i></a>
                                    @endif
                                </td>
                            </tr>
                            @php($i++)
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">No recharge found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
        $("#recharge-form").validate({
            rules: {
                order_no: {
                    required: true
                },
                amount: {
                    required: true
                },
                payment_proof: {
                    required: true
                }
            },
            errorPlacement: function(error, element){
                if (element.hasClass('order-no')) {
                    error.insertAfter(element.closest(".input-group"));
                } else {
                    error.insertAfter(element);
                }
            }
        });
        $(".generate-order-no").on('click', function(){
            $("#order_no").val(orderNo(10));
        });
	});
    
    function orderNo(length) {
        var result           = '';
        var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        var charactersLength = characters.length;
        for ( var i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }
        return result;
    }
</script>
@endsection