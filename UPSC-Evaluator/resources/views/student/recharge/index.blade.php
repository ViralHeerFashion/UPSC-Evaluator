@extends('student.template.main')
@section('title', 'Recharge')
@section('style')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>1
<style>
    .contact-details-box .tab-button-style-2{gap: 8px;}
    .fixed-amount-card{padding: 25px 45px;font-size: var(--font-size-b2);color: var(--color-heading);background: var(--color-dark);border-radius: var(--radius-small);}
    .active .fixed-amount-card{background-color: #805AF5!important;}
    .mb-10px{margin-bottom: 10px;}
    .error{color: #cb2c2c;}
    .full-page-loader {position: fixed;top: 0;left: 0;width: 100%;height: 100%;background-color: rgba(14, 12, 21, 0.9);display: flex;justify-content: center;align-items: center;z-index: 9999;opacity: 0;pointer-events: none;transition: opacity 0.3s ease;}
    .full-page-loader.active {opacity: 1;pointer-events: all;}
    .loader-content {text-align: center;color: white;}
    .loader-spinner {width: 50px;height: 50px;border: 5px solid rgba(128, 90, 245, 0.3);border-radius: 50%;border-top-color: #805AF5;animation: spin 1s ease-in-out infinite;margin: 0 auto 20px;}
    .loader-text {font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;font-size: 18px;margin-top: 15px;color: #CD99FF;}
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .text-bold{font-weight: bold;}
    /* .you-will-get-container{display: none;} */
</style>
@endsection
@section('tab-name')
<div class="banner-area">
    <div class="settings-area">
        <h3 class="title">Recharge</h3>
    </div>
</div>
@endsection
@section('content')
<div class="full-page-loader" id="loader">
    <div class="loader-content">
        <div class="loader-spinner"></div>
        <div class="loader-text">Processing your request...</div>
    </div>
</div>
<div class="contact-details-box">
    <!-- <h3 class="title">Recharge your wallet</h3> -->
    <h3 class="text-center">
        ₹{{number_format($current_balance, 2)}}
        <p>Current Balance</p>
    </h3>
    <div class="profile-details-tab">
        <form action="{{ route('student.recharge.createOrder') }}" method="post" id="recharge-form" class="rbt-profile-row rbt-default-form row row--15">
            @csrf
            <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="form-group">
                    <label for="amount">Amount <span class="text-success text-bold you-will-get-container">(Amount to be credited: ₹49)</span></label>
                    <input type="number" name="amount" id="amount" placeholder="Enter your Amount" value="49">
                </div>
            </div>
            <div class="col-12">
                <div class="form-group">
                    <button type="submit" class="btn-default">Recharge Proceed</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-6 mb-10px">
                <a href="javascript:void(0);" data-amount="49" class="set-recharge-amount active">
                    <div class="fixed-amount-card text-center">
                        <h4 class="mb-0">49</h4>
                        <span>Amount</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-6 mb-10px">
                <a href="javascript:void(0);" data-amount="349" class="set-recharge-amount">
                    <div class="fixed-amount-card text-center">
                        <h4 class="mb-0">349</h4>
                        <span>Amount</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-6 mb-10px">
                <a href="javascript:void(0);" data-amount="799" class="set-recharge-amount">
                    <div class="fixed-amount-card text-center">
                        <h4 class="mb-0">799</h4>
                        <span>Amount</span>
                    </div>
                </a>
            </div>
            <div class="col-md-3 col-sm-6 col-6 mb-10px">
                <a href="javascript:void(0);" data-amount="1299" class="set-recharge-amount">
                    <div class="fixed-amount-card text-center">
                        <h4 class="mb-0">1299</h4>
                        <span>Amount</span>
                    </div>
                </a>
            </div>
        </div>
        <p>For more details on recharge and bonuses <a href="{{ route('home') }}#pricing" style="color: #805AF5;">click here</a></p>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        $(".wallet-recharge").addClass('active');
        $(".set-recharge-amount").on('click', function(){
            let amount = $(this).data('amount');
            var sentence = null; 
            if (amount == 49) {
                sentence = "(Amount to be credited: ₹49)";                
            } else if(amount == 349) {
                sentence = "(Amount to be credited: ₹405)";
            } else if(amount == 799) {
                sentence = "(Amount to be credited: ₹1125)";
            } else if(amount == 1299) {
                sentence = "(Amount to be credited: ₹2025)";
            }           

            if (sentence != null) {
                $(".you-will-get-container").text(sentence);
                $(".you-will-get-container").show();
            } else {
                $(".you-will-get-container").hide();
            }

            $(".set-recharge-amount").removeClass('active');
            $(this).addClass('active');
            $("#amount").val(amount);
        });
        $("#amount").on('blur', function(){
            let amount = parseInt($(this).val());
            let fixed_amounts = [49, 349, 799, 1299];
            $(".set-recharge-amount").removeClass('active');
            if (fixed_amounts.includes(amount)) {
                $('.set-recharge-amount[data-amount="'+amount+'"]').addClass('active');
                var sentence = null; 
                if (amount == 49) {
                    sentence = "(Amount to be credited: ₹49)";                
                } else if(amount == 349) {
                    sentence = "(Amount to be credited: ₹405)";
                } else if(amount == 799) {
                    sentence = "(Amount to be credited: ₹1125)";
                } else if(amount == 1299) {
                    sentence = "(Amount to be credited: ₹2025)";
                }           
                
                if (sentence != null) {
                    $(".you-will-get-container").text(sentence);
                    $(".you-will-get-container").show();
                } else {
                    $(".you-will-get-container").hide();
                }
            } else {
                $(".you-will-get-container").hide();
            }
        });
        $("#recharge-form").validate({
            rules: {
                amount: {
                    required: true,
                    min: 49
                }
            },
            messages: {
                amount: {
                    min: "Minimum 49 recharge mandatory"
                }
            },
            submitHandler: function(form){
                let form_data = $('#recharge-form')
                            .find(':input')
                            .filter(function () {
                                return $(this).is(':visible') || $(this).attr('name') === '_token';
                            })
                            .serialize(); 
                            
                $.ajax({
                    url: $("#recharge-form").attr('action'),
                    method: "POST",
                    data: form_data,
                    beforeSend: function(){
                        $('#loader').addClass('active');
                    },
                    success: function(response){
                        $('#loader').removeClass('active');
                        var options = {
                            key: "{{ config('razorpay.api_key') }}",
                            amount: response.amount, 
                            currency: "INR",
                            name: "Aspire Scan",
                            description: response.order_id,
                            image: "https://aspirescan.com/public/images/icon.png",
                            order_id: response.razorpay_order_id,
                            prefill: {
                                name: "{{ auth()->user()->name }}",
                                email: "{{ auth()->user()->email }}",
                                contact: "{{ auth()->user()->phone }}"
                            },
                            theme: {
                                "color": "#805AF5"
                            },
                            callback_url: response.callback_url
                        };
                        var rzp = new Razorpay(options);
                        rzp.open();
                    }
                });
                
            }
        });
    });
</script>
@endsection