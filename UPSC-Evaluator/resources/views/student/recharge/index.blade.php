@extends('student.template.main')
@section('title', 'Recharge')
@section('style')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<style>
    :root {
        --bg-color: #0E0C15;
        --card-color: #18191c;
        --primary-accent: #020202ff;
        --secondary-accent: #CD99FF;
        --text-primary: #F5F5F7;
        --text-secondary: #A1A1A6;
        --border-color: rgba(255, 255, 255, 0.1);
        --success-color: #30D158;
        --warning-color: #FF9F0A;
        --error-color: #FF453A;
        --highlight-color: rgba(128, 90, 245, 0.15);
        --free-gradient: linear-gradient(135deg, #3a7bd5, #00d2ff);
        --booster-gradient: linear-gradient(135deg, #8E2DE2, #4A00E0);
        --mains-gradient: linear-gradient(135deg, #f46b45, #eea849);
        --rank-gradient: linear-gradient(135deg, #c0392b, #8e44ad);
    }
    .contact-details-box {padding-top: 25px;}
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



    .header {text-align: center;margin-bottom: 40px;animation: fadeIn 1s ease-out;}
    .header h1 {margin-top: 10px;font-size: 2.5rem;margin-bottom: 12px;background: linear-gradient(90deg, var(--secondary-accent), #8A2BE2);-webkit-background-clip: text;-webkit-text-fill-color: transparent;font-weight: 800;}
    .header p {color: var(--text-secondary);font-size: 1.2rem;max-width: 600px;margin: 0 auto;line-height: 1.6;}
    .pricing-card {background-color: var(--card-color);border-radius: 16px;padding: 0;box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);border: 1px solid var(--border-color);transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);display: flex;flex-direction: column;overflow: hidden;position: relative;opacity: 0;transform: translateY(20px);animation: cardEntrance 0.6s ease forwards;margin-bottom: 15px;}
    .pricing-card:nth-child(1) { animation-delay: 0.1s; }
    .pricing-card:nth-child(2) { animation-delay: 0.2s; }
    .pricing-card:nth-child(3) { animation-delay: 0.3s; }
    .pricing-card:nth-child(4) { animation-delay: 0.4s; }
    .pricing-card::before {content: '';position: absolute;top: 0;left: 0;right: 0;height: 5px;transition: all 0.5s ease;}
    .pricing-card:hover {transform: translateY(-12px) scale(1.02);box-shadow: 0 20px 40px rgba(205, 153, 255, 0.2);z-index: 10;}
    .pricing-card:hover::before {height: 8px;}
    .card-header {padding: 25px 25px 5px;position: relative;transition: all 0.3s ease;}
    .pricing-card:hover .card-header {transform: translateY(-5px);}
    .popular-badge {position: absolute;top: 15px;right: 15px;background: var(--booster-gradient);color: white;font-size: 12px;font-weight: 600;padding: 5px 12px;border-radius: 20px;box-shadow: 0 4px 15px rgba(142, 45, 226, 0.4);animation: pulse 2s infinite;}
    .plan-title {font-size: 25px;font-weight: 700;/* margin-bottom: 8px; */transition: all 0.3s ease;}
    .pricing-card:hover .plan-title {transform: scale(1.05);}
    .free-card .plan-title { color: #00d2ff; }
    .booster-card .plan-title { color: #8E2DE2; }
    .mains-card .plan-title { color: #eea849; }
    .rank-card .plan-title { color: #8e44ad; }
    .plan-subtitle {color: var(--text-secondary);font-size: 15px;margin-bottom: 0;line-height: 1.5;}
    .price-container {display: flex;align-items: baseline;margin: 10px 0;transition: all 0.3s ease;}
    .pricing-card:hover .price-container {transform: scale(1.05);}
    .plan-price {font-size: 27px;font-weight: 800;position: relative;display: inline-block;}
    .plan-price::after {content: '';position: absolute;bottom: -5px;left: 0;width: 0;height: 2px;background: currentColor;transition: width 0.5s ease;}
    .pricing-card:hover .plan-price::after {width: 100%;}
    .price-period {color: var(--text-secondary);font-size: 15px;margin-left: 5px;}
    .card-body {padding: 0 20px 0px;flex-grow: 1;}
    .includes-title {font-size: 17px;font-weight: 600;margin-bottom: 15px;color: var(--text-primary);display: flex;align-items: center;}
    .includes-title i {margin-right: 10px;font-size: 1.1rem;}
    .card-footer{padding-bottom: 15px;}
    .free-card .includes-title i { color: #00d2ff; }
    .booster-card .includes-title i { color: #8E2DE2; }
    .mains-card .includes-title i { color: #eea849; }
    .rank-card .includes-title i { color: #8e44ad; }
    .feature-list {list-style: none;margin-bottom: 15px;}
    .feature-item {display: flex;align-items: center;margin-bottom: 8px;font-size: 13px;opacity: 0;transform: translateX(-10px);animation: featureSlideIn 0.5s ease forwards;}
    .feature-item:nth-child(1) { animation-delay: 0.5s; }
    .feature-item:nth-child(2) { animation-delay: 0.6s; }
    .feature-item:nth-child(3) { animation-delay: 0.7s; }
    .feature-icon {width: 22px;height: 22px;border-radius: 50%;display: flex;align-items: center;justify-content: center;margin-right: 12px;font-size: 0.7rem;transition: all 0.3s ease;}
    .feature-item:hover .feature-icon {transform: scale(1.2) rotate(10deg);}
    .free-card .feature-icon { background-color: rgba(0, 210, 255, 0.15); color: #00d2ff; }
    .booster-card .feature-icon { background-color: rgba(142, 45, 226, 0.15); color: #8E2DE2; }
    .mains-card .feature-icon { background-color: rgba(238, 168, 73, 0.15); color: #eea849; }
    .rank-card .feature-icon { background-color: rgba(142, 68, 173, 0.15); color: #8e44ad; }
    .bonus-highlight {color: var(--success-color);font-weight: 600;position: relative;display: inline-block;}
    .bonus-highlight::after {content: '';position: absolute;bottom: -2px;left: 0;width: 100%;height: 2px;background: var(--success-color);transform: scaleX(0);transform-origin: right;transition: transform 0.3s ease;}
    .feature-item:hover .bonus-highlight::after {transform: scaleX(1);transform-origin: left;}
    .free-card::before { background: var(--free-gradient); }
    .booster-card::before { background: var(--booster-gradient); }
    .mains-card::before { background: var(--mains-gradient); }
    .rank-card::before { background: var(--rank-gradient); }
    @keyframes fadeIn {from { opacity: 0; transform: translateY(-10px); }to { opacity: 1; transform: translateY(0); }}
    @keyframes cardEntrance {from {     opacity: 0;     transform: translateY(30px) scale(0.95); }to {     opacity: 1;     transform: translateY(0) scale(1); }}
    @keyframes featureSlideIn {from {     opacity: 0;     transform: translateX(-10px); }to {     opacity: 1;     transform: translateX(0); }}
    @keyframes pulse {0% { transform: scale(1); }50% { transform: scale(1.05); }100% { transform: scale(1); }}
    .sparkle {position: absolute;background: #fff;border-radius: 50%;pointer-events: none;opacity: 0;animation: sparkle 1s ease-out forwards;}
    @keyframes sparkle {0% {    transform: translate(0, 0) scale(0);    opacity: 1;}100% {    transform: translate(var(--tx), var(--ty)) scale(1);    opacity: 0;}}
    @media (max-width: 992px) {.pricing-container {    grid-template-columns: repeat(2, 1fr);}}
    @media (max-width: 768px) {.pricing-container {    grid-template-columns: 1fr;    max-width: 450px;}.header h1 {    font-size: 2rem;}.header p {    font-size: 13px;}}
    @media (max-width: 480px) {.pricing-card {    padding: 0;}.plan-price {    font-size: 2.2rem;}.card-header, .card-body, .card-footer {    padding-left: 20px;    padding-right: 20px;}}
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
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 recharge-element">
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
        <div class="header">
            <h1>Pricing Plans For Everyone</h1>
            <p>Choose the perfect plan that fits your preparation needs and budget</p>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="javascript:void(0);" class="set-recharge" data-amount="49" data-get-amount="49">
                    <div class="pricing-card free-card">
                        <div class="card-header">
                            <div class="plan-title">Starter</div>
                            <div class="plan-subtitle">Experience the full platform</div>
                            <div class="price-container">
                                <div class="plan-price">₹49</div>
                                <div class="price-period">forever</div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="includes-title">
                                <i class="fas fa-check-circle"></i> What's included
                            </div>
                            <ul class="feature-list">
                                <li class="feature-item">
                                    <div class="feature-icon"><i class="fas fa-wallet"></i></div>
                                    <span>₹49 Wallet Balance</span>
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon"><i class="fas fa-file-alt"></i></div>
                                    <span>Evaluates up to 40 pages</span>
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon"><i class="fas fa-star"></i></div>
                                    <span>Full access to all features</span>
                                </li>
                            </ul>
                        </div>
<!--                         <div class="card-footer">
                            <button class="btn-default btn-border">Get Started</button>
                        </div> -->
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="javascript:void(0);" class="set-recharge" data-amount="349" data-get-amount="384">
                    <div class="pricing-card booster-card">
                        <div class="card-header">
                            <div class="popular-badge">Best Offer</div>
                            <div class="plan-title">Booster Pack</div>
                            <div class="plan-subtitle">For consistent weekly practice</div>
                            <div class="price-container">
                                <div class="plan-price">₹349</div>
                                <div class="price-period">one-time</div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="includes-title">
                                <i class="fas fa-gift"></i> Great value
                            </div>
                            <ul class="feature-list">
                                <li class="feature-item">
                                    <div class="feature-icon"><i class="fas fa-rupee-sign"></i></div>
                                    <span>Pay ₹349, Get <span class="bonus-highlight">₹384 Value</span></span>
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                                    <span><span class="bonus-highlight">+10% Bonus</span></span>
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon"><i class="fas fa-copy"></i></div>
                                    <span>Evaluates up to <span class="bonus-highlight">320 pages</span></span>
                                </li>
                            </ul>
                        </div>
<!--                         <div class="card-footer">
                            <button class="btn-default">Get Started</button>
                        </div> -->
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="javascript:void(0);" class="set-recharge" data-amount="999" data-get-amount="1250">
                    <div class="pricing-card mains-card">
                        <div class="card-header">
                            <div class="plan-title">Mains Cracker</div>
                            <div class="plan-subtitle">For rigorous test series preparation</div>
                            <div class="price-container">
                                <div class="plan-price">₹999</div>
                                <div class="price-period">one-time</div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="includes-title">
                                <i class="fas fa-bolt"></i> Premium features
                            </div>
                            <ul class="feature-list">
                                <li class="feature-item">
                                    <div class="feature-icon"><i class="fas fa-rupee-sign"></i></div>
                                    <span>Pay ₹999, Get <span class="bonus-highlight">₹1250 Value</span></span>
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                                    <span><span class="bonus-highlight">+25% Bonus</span></span>
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon"><i class="fas fa-copy"></i></div>
                                    <span>Evaluates up to <span class="bonus-highlight">1042 pages</span></span>
                                </li>
                            </ul>
                        </div>
<!--                         <div class="card-footer">
                            <button class="btn-default btn-border">Get Started</button>
                        </div> -->
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="javascript:void(0);" class="set-recharge" data-amount="1499" data-get-amount="2023">
                    <div class="pricing-card rank-card">
                        <div class="card-header">
                            <div class="plan-title">Rank Booster</div>
                            <div class="plan-subtitle">For the entire Mains season</div>
                            <div class="price-container">
                                <div class="plan-price">₹1,499</div>
                                <div class="price-period">one-time</div>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <div class="includes-title">
                                <i class="fas fa-crown"></i> Ultimate package
                            </div>
                            <ul class="feature-list">
                                <li class="feature-item">
                                    <div class="feature-icon"><i class="fas fa-rupee-sign"></i></div>
                                    <span>Pay ₹1,499, Get <span class="bonus-highlight">₹2,023 Value</span></span>
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                                    <span><span class="bonus-highlight">+35% Bonus</span></span>
                                </li>
                                <li class="feature-item">
                                    <div class="feature-icon"><i class="fas fa-copy"></i></div>
                                    <span>Evaluates up to <span class="bonus-highlight">1685 pages</span></span>
                                </li>
                            </ul>
                        </div>
<!--                         <div class="card-footer">
                            <button class="btn-default btn-border">Get Started</button>
                        </div> -->
                    </div>
                </a>
            </div>
        </div>
        {{--
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
        --}}
    </div>

</div>
@endsection
@section('script')
<script>
    var current_balance = parseFloat("{{ $current_balance }}");
        
    $(document).ready(function(){
        $(".wallet-recharge").addClass('active');
        $(".set-recharge-amount").on('click', function(){
            let amount = $(this).data('amount');
            var sentence = null; 
            if (amount == 49) {
                sentence = "(Amount to be credited: ₹49)";                
            } else if(amount == 349) {
                sentence = "(Amount to be credited: ₹384)";
            } else if(amount == 999) {
                sentence = "(Amount to be credited: ₹1250)";
            } else if(amount == 1499) {
                sentence = "(Amount to be credited: ₹2023)";
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
        $(".set-recharge").on('click', function(){
            let amount = $(this).data('amount');
            let get_amount = parseFloat($(this).data('get-amount'));
            let after_total_wallet = current_balance + get_amount;
            $(".you-will-get-container").text("(After successfull transaction your wallet total will be "+after_total_wallet.toFixed(2)+")");
            $("#amount").val(amount);
            document.getElementsByClassName("recharge-element")[0].scrollIntoView({
                block: "center"
            });
        });
        $("#amount").on('blur', function(){
            let amount = parseInt($(this).val());
            let fixed_amounts = [49, 349, 999, 1499];
            $(".set-recharge-amount").removeClass('active');
            if (fixed_amounts.includes(amount)) {
                $('.set-recharge-amount[data-amount="'+amount+'"]').addClass('active');
                var get_amount = 0; 
                if (amount == 49) {
                    get_amount = 49;             
                } else if(amount == 349) {
                    get_amount = 384;
                } else if(amount == 999) {
                    get_amount = 1250;
                } else if(amount == 1499) {
                    get_amount = 2023;
                }           
                
                if (get_amount > 0) {
                    let after_total_wallet = current_balance + get_amount;
                    $(".you-will-get-container").text("(After successfull transaction your wallet total will be "+after_total_wallet.toFixed(2)+")");
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

         document.querySelectorAll('.pricing-card').forEach(card => {
            card.addEventListener('mouseenter', function(e) {
                for (let i = 0; i < 15; i++) {
                    createSparkle(e, this);
                }
            });
        });

        function createSparkle(e, card) {
            const sparkle = document.createElement('div');
            sparkle.classList.add('sparkle');
            
            const size = Math.random() * 5 + 2;
            const cardRect = card.getBoundingClientRect();
            
            // Position sparkle relative to mouse position within card
            const x = e.clientX - cardRect.left;
            const y = e.clientY - cardRect.top;
            
            sparkle.style.width = `${size}px`;
            sparkle.style.height = `${size}px`;
            sparkle.style.left = `${x}px`;
            sparkle.style.top = `${y}px`;
            
            // Random direction and distance
            const angle = Math.random() * Math.PI * 2;
            const distance = Math.random() * 50 + 20;
            const tx = Math.cos(angle) * distance;
            const ty = Math.sin(angle) * distance;
            
            sparkle.style.setProperty('--tx', `${tx}px`);
            sparkle.style.setProperty('--ty', `${ty}px`);
            
            card.appendChild(sparkle);
            
            // Remove sparkle after animation completes
            setTimeout(() => {
                sparkle.remove();
            }, 1000);
        }
    });
</script>
@endsection