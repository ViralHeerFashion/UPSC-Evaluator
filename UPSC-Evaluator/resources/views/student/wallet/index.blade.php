@extends('student.template.main')
@section('title', 'Wallet')
@section('style')
<style>
    .mb-5px{margin-bottom: 5px!important;}
</style>
@endsection
@section('tab-name')
<div class="banner-area">
    <div class="settings-area">
        <h3 class="title">Wallet</h3>
    </div>
</div>
@endsection
@section('content')
<div class="container">

    <div class="contact-details-box">
        <div class="balance text-center">
            <h3 class="mb-5px">
                ₹{{ number_format($balance) }}
            </h3>
            <p>Balance</p>
        </div>
        <table class="table text-center text-light">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Credit/debit</th>
                </tr>
            </thead>
            <tbody>
                @php($i=1)
                @foreach($transactions as $t)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ date("d-m-Y", strtotime($t->created_at)) }}</td>
                    <td>
                        @if($t->amount > 0)
                        <span class="text-success">₹{{ number_format($t->amount) }}</span>
                        @else
                        <span class="text-danger">₹{{ number_format($t->amount) }}</span>
                        @endif
                    </td>
                    <td>
                        @if($t->amount > 0)
                        Credit
                        @else
                        Debit
                        @endif
                    </td>
                </tr>
                @php($i++)
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $(".wallet").addClass('active');
    });
</script>
@endsection