@extends('pages.theme.main')
@section('title', 'Home page')
@section('styles')
<style>
    .rainbow-pricing, .pricing-table-inner{width: 100%!important;}
</style>
@endsection
@section('content')
<div class="slider-area slider-style-1 variation-default slider-bg-image bg-banner1 slider-bg-shape" data-black-overlay="1">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="inner text-center mt--140">
                    <h1 class="title display-one">Unlock Your UPSC Potential
                        <br> <span class="header-caption">
                            <span class="cd-headline rotate-1">
                                <span class="cd-words-wrapper" style="width: 221px;">
                                    <b class="theme-gradient is-visible">AI-Powered</b>
                                    <b class="theme-gradient is-hidden">AI-Powered</b>
                                    <b class="theme-gradient is-hidden">AI-Powered</b>
                                </span>
                        </span>
                        </span> Evaluation
                    </h1>
                    <p class="description">Get Personalized Feedback for Your UPSC Answers with <br>Aspire Scan's AI Technology.</p>
                    <div class="form-group">
                        <textarea name="text" id="slider-text-area" cols="30" rows="2" placeholder="Get your first evaluation right NOW." readonly></textarea>
                        <a class="btn-default @@btnClass" href="/login">Start Now – its’s FREE</a>
                    </div>
                    <div class="inner-shape">
                        <img src="{{ asset('public/images/icon-shape-one.png') }}" alt="Icon Shape" class="iconshape iconshape-one">
                        <img src="{{ asset('public/images/icon-shape-two.png') }}" alt="Icon Shape" class="iconshape iconshape-two">
                        <img src="{{ asset('public/images/icon-shape-three.png') }}" alt="Icon Shape" class="iconshape iconshape-three">
                        <img src="{{ asset('public/images/icon-shape-four.png') }}" alt="Icon Shape" class="iconshape iconshape-four">
                    </div>
                </div>
            </div>
            <div class="col-lg-11 col-xl-11 justify-content-center">
                <div class="slider-frame">
                    <img class="slider-image-effect" src="{{ asset('public/images/answer-evaluation.png') }}" alt="Banner Images">
                </div>
            </div>
        </div>
    </div>
    <div class="bg-shape">
        <img class="bg-shape-one" src="{{ asset('public/images/bg-shape-four.png') }}" alt="Bg Shape">
        <img class="bg-shape-two" src="{{ asset('public/images/bg-shape-five.png') }}" alt="Bg Shape">
    </div>
</div>



<div class="rainbow-service-area rainbow-section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center pb--60" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                    <h4 class="subtitle">
                        <span class="theme-gradient">Aspire Scan unlocks the potential of AI for UPSC</span>
                    </h4>
                    <h2 class="title mb--0">UPSC-Style Mains Evaluation-In <br>Minutes</h2>
                </div>
            </div>
        </div>

        <div class="row row--30 align-items-center">
            <div class="col-lg-12">
                <div class="rainbow-default-tab style-three generator-tab-defalt">

                    <div class="rainbow-tab-content tab-content">
                        <div class="tab-pane fade show active" id="video-generate" role="tabpanel" aria-labelledby="video-generator-tab">
                            <div class="inner">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="section-title">
                                            <h2 class="title">Evaluations aligned to UPSC Standard.</h2>
                                            <div class="features-section">
                                                <ul class="list-style--1">
                                                    <li><i class="fa-regular fa-circle-check"></i>Question Deconstruction</li>
                                                    <li><i class="fa-regular fa-circle-check"></i>Micro Marking Grid</li>
                                                    <li><i class="fa-regular fa-circle-check"></i>Gold Standard Model Answers</li>
                                                    <li><i class="fa-regular fa-circle-check"></i>Gap Analysis with Detailed Feedback</li>
                                                    <li><i class="fa-regular fa-circle-check"></i>Available in English & Hindi both</li>
                                                </ul>
                                            </div>
                                            <div class="read-more"><a class="btn-default color-blacked" href="{{ auth()->check() ? route('student.mains-evaluation') : route('home').'#pricing' }}">Start Exploring Now <i class="fa-sharp fa-solid fa-arrow-right"></i></a></div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 mt_md--30 mt_sm--30">
                                        <div class="export-img">
                                            <div class="inner-without-padding">
                                                <div class="export-img img-bg-shape">
                                                    <img src="{{ asset('public/images/second-slider.png') }}" alt="Chat example Image">
                                                    <div class="image-shape"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="rainbow-advance-tab-area aiwave-bg-gradient rainbow-section-gap-big">
    <div class="container">
        <div class="html-tabs" data-tabs="true">
            <div class="row row--30">
                <div class="col-lg-12">
                    <div class="tab-content">
                        <div class="tab-pane fade show active advance-tab-content-1 right-top" id="home-3" role="tabpanel" aria-labelledby="home-tab-3">
                            <div class="rainbow-splite-style">
                                <div class="split-wrapper">
                                    <div class="row g-0 radius-10 align-items-center">
                                        <div class="col-lg-12 col-xl-5 col-12">
                                            <div class="thumbnail">
                                                <img class="radius" src="{{ asset('public/images/step-one.png') }}" alt="split Images">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-xl-7 col-12">
                                            <div class="split-inner">
                                                <div class="subtitle">
                                                    <span class="theme-gradient">How it works</span>
                                                </div>
                                                <h2 class="title sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="200">
                                                    Upload Your Answer Sheet
                                                </h2>
                                                <p class="description sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="300">
                                                    Simply digitize your hard work. Whether you're scanning your test series booklet or just taking clear photos with your phone, getting started is seamless. Combine your pages into a single PDF and upload it directly to our platform. Our system is built to handle your documents with ease, kicking off the evaluation process instantly.
                                                </p>
                                                <ul>
                                                    <li>
                                                        <b>Action:</b> Scan or photograph your answer sheets.
                                                    </li>
                                                    <li>
                                                        <b>Result:</b> A single PDF ready for intelligent analysis.
                                                    </li>
                                                </ul>
                                                <div class="view-more-button mt--35 sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="400">
                                                    <a class="btn-default color-blacked" href="{{ route('student.login') }}">Try It Now <i class="fa-sharp fa-light fa-arrow-right ml--5"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade advance-tab-content-1" id="profile-3" role="tabpanel" aria-labelledby="profile-tab-3">
                            <div class="rainbow-splite-style">
                                <div class="split-wrapper">
                                    <div class="row g-0 radius-10 align-items-center">
                                        <div class="col-lg-12 col-xl-5 col-12">
                                            <div class="thumbnail">
                                                <img class="radius" src="{{ asset('public/images/step-two.png') }}" alt="split Images">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-xl-7 col-12">
                                            <div class="split-inner">
                                                <div class="subtitle">
                                                    <span class="theme-gradient">Intelligent Answer Recognition</span>
                                                </div>
                                                <h2 class="title sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="200">
                                                    Intelligent Answer Recognition
                                                </h2>
                                                <p class="description sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="300">
                                                    This is where the magic happens. Once uploaded, our advanced AI gets to work. It is trained to read and understand handwritten text, accurately identifying where each question begins and ends. The system intelligently digitizes your answers, preparing them for our comprehensive evaluation engine.
                                                </p>
                                                <ul>
                                                    <li>
                                                        <b>Behind the Scenes:</b> Your handwritten answers are read and converted into a digital format.
                                                    </li>
                                                    <li>
                                                        <b>Result:</b> Your text is cleanly structured and prepared for deep analysis.
                                                    </li>
                                                </ul>
                                                <div class="view-more-button mt--35 sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="400">
                                                    <a class="btn-default color-blacked" href="{{ route('student.login') }}">Try It Now <i class="fa-sharp fa-light fa-arrow-right ml--5"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade advance-tab-content-1" id="contact-3" role="tabpanel" aria-labelledby="contact-tab-3">
                            <div class="rainbow-splite-style">
                                <div class="split-wrapper">
                                    <div class="row g-0 radius-10 align-items-center">
                                        <div class="col-lg-12 col-xl-5 col-12">
                                            <div class="thumbnail">
                                                <img class="radius" src="{{ asset('public/images/step-three.png') }}" alt="split Images">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-xl-7 col-12">
                                            <div class="split-inner">
                                                <div class="subtitle">
                                                    <span class="theme-gradient">Receive Your Comprehensive Evaluation</span>
                                                </div>
                                                <h2 class="title sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="200">Receive Your Comprehensive Evaluation</h2>
                                                <p class="description sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="300">Forget the wait. Get instant, in-depth feedback. Within moments, personalized report is ready. This isn't just a score; it's a complete diagnostic breakdown modeled on the UPSC evaluation framework. For every question, you receive:</p>
                                                <ul>
                                                    <li>
                                                        <b>Question Deconstruction:</b> Understand the core demands of the question.
                                                    </li>
                                                    <li>
                                                        <b>Micro-Marking Grid:</b> See a granular score breakdown for introduction, body, and conclusion.
                                                    </li>
                                                    <li>
                                                        <b>Gap Analysis & Corrective Actions:</b> Pinpoint exactly what was missing and get specific, actionable advice on how to fix it.
                                                    </li>
                                                    <li>
                                                        <b>Model Answer:</b> Compare your attempt against a benchmark answer to understand what excellence looks like.
                                                    </li>
                                                </ul>
                                                <div class="view-more-button mt--35 sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="400">
                                                    <a class="btn-default color-blacked" href="{{ route('student.login') }}">Try It Now <i class="fa-sharp fa-light fa-arrow-right ml--5"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade advance-tab-content-1" id="explore-3" role="tabpanel" aria-labelledby="explore-tab-3">
                            <div class="rainbow-splite-style">
                                <div class="split-wrapper">
                                    <div class="row g-0 radius-10 align-items-center">
                                        <div class="col-lg-12 col-xl-5 col-12">
                                            <div class="thumbnail">
                                                <img class="radius" src="{{ asset('public/images/step-four.png') }}" alt="split Images">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-xl-7 col-12">
                                            <div class="split-inner">
                                                <div class="subtitle">
                                                    <span class="theme-gradient">Analyze, Act, and Achieve</span>
                                                </div>
                                                <h2 class="title sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="200">Analyze, Act, and Achieve</h2>
                                                <p class="description sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="300">Turn insights into marks. Your detailed report is your personal roadmap to improvement. Use the corrective actions to refine your knowledge base and answer structure. Study the model answers to master the art of writing for the UPSC Mains. By consistently applying the feedback, you create a powerful loop of practice, analysis, and strategic improvement that directly translates to better performance.</p>
                                                <ul>
                                                    <li>
                                                        <b>Action:</b> Apply the targeted feedback to your next practice session.
                                                    </li>
                                                    <li>
                                                        <b>Result:</b> Systematically strengthen your weaknesses and climb the marks ladder.
                                                    </li>
                                                </ul>
                                                <div class="view-more-button mt--35 sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="400">
                                                    <a class="btn-default color-blacked" href="{{ route('student.login') }}">Try It Now <i class="fa-sharp fa-light fa-arrow-right ml--5"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 mt--60">
                    <div class="advance-tab-button advance-tab-button-1 right-top">
                        <ul class="nav nav-tabs tab-button-list" id="myTab-3" role="tablist">

                            <li class="col-lg-3 nav-item" role="presentation">
                                <a href="#" class="nav-link tab-button active" id="home-tab-3" data-bs-toggle="tab" data-bs-target="#home-3" role="tab" aria-controls="home-3" aria-selected="true">
                                    <div class="tab">
                                        <div class="count-text">
                                            <span class="theme-gradient">01</span>
                                        </div>
                                        <h4 class="title">Upload Your Answer Sheet</h4>
                                    </div>
                                </a>
                            </li>

                            <li class="col-lg-3 nav-item" role="presentation">
                                <a href="#" class="nav-link tab-button" id="profile-tab-3" data-bs-toggle="tab" data-bs-target="#profile-3" role="tab" aria-controls="profile-3" aria-selected="false">
                                    <div class="tab">
                                        <div class="count-text">
                                            <span class="theme-gradient">02</span>
                                        </div>
                                        <h4 class="title">Intelligent Answer Recognition</h4>
                                    </div>
                                </a>
                            </li>

                            <li class="col-lg-3 nav-item" role="presentation">
                                <a href="#" class="nav-link tab-button" id="contact-tab-3" data-bs-toggle="tab" data-bs-target="#contact-3" role="tab" aria-controls="contact-3" aria-selected="false">
                                    <div class="tab">
                                        <div class="count-text">
                                            <span class="theme-gradient">03</span>
                                        </div>
                                        <h4 class="title">Receive Your Comprehensive Evaluation</h4>
                                    </div>
                                </a>
                            </li>
                            <li class="col-lg-3 nav-item" role="presentation">
                                <a href="#" class="nav-link tab-button" id="explore-tab-3" data-bs-toggle="tab" data-bs-target="#explore-3" role="tab" aria-controls="explore-3" aria-selected="false">
                                    <div class="tab">
                                        <div class="count-text">
                                            <span class="theme-gradient">04</span>
                                        </div>
                                        <h4 class="title">Analyze, Act, and Achieve</h4>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bg-shape">
        <img src="{{ asset('public/images/split-bg-shape.png') }}" alt="Bg Shape">
    </div>
</div>



<div class="aiwave-pricing-area wrapper rainbow-section-gap-big" id="pricing">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center sal-animate" data-sal="slide-up" data-sal-duration="400" data-sal-delay="150">
                    <h4 class="subtitle">
                        <span class="theme-gradient">Pricing</span>
                    </h4>
                    <h2 class="title w-600 mb--40">
                        Pricing plans for everyone
                    </h2>
                </div>
            </div>
        </div>
        @php($redirect_link = auth()->check() ? route('student.recharge') : route('student.login'))
        <div class="tab-content p-0 bg-transparent border-0 border bg-light" id="nav-tabContent">
            <div class="tab-pane fade active show" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                <div class="row row--15 mt_dec--40">
                    <div class="col-xl-3 col-lg-6 col-md-6 col-12 mt--40">
                        <div class="rainbow-pricing style-aiwave">
                            <div class="pricing-table-inner">
                                <div class="pricing-top">
                                    <div class="pricing-header">
                                        <div class="icon">
                                            <i class="fa-regular fa-circle-radiation"></i>
                                        </div>
                                        <h4 class="title color-var-one">Starter</h4>
                                        <p class="subtitle">Experience the full platform</p>
                                        <div class="pricing">
                                            <span class="price-text">Free</span>
                                        </div>
                                    </div>
                                    <div class="pricing-body">
                                        <div class="features-section">
                                            <h6>Includes</h6>
                                            <ul class="list-style--1">
                                                <li>
                                                    <i class="fa-regular fa-circle-check"></i> ₹15 Free Wallet Balance
                                                </li>
                                                <li>
                                                    <i class="fa-regular fa-circle-check"></i> Evaluates up to 12 pages
                                                </li>
                                                <li>
                                                    <i class="fa-regular fa-circle-check"></i> Full access to all features
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pricing-footer">
                                    <a class="btn-default btn-border" href="{{ $redirect_link }}">Get Started</a>
                                    <p class="bottom-text">Limited Offer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-12 mt--40">
                        <div class="rainbow-pricing style-aiwave active">
                            <div class="pricing-table-inner">
                                <div class="pricing-top">
                                    <div class="pricing-header">
                                        <div class="icon">
                                            <i class="fa-sharp fa-regular fa-flower"></i>
                                        </div>
                                        <h4 class="title color-var-two">🚀 Booster Pack</h4>
                                        <p class="subtitle">For consistent weekly practice</p>
                                        <div class="pricing">
                                            <span class="price-text">349</span>
                                        </div>
                                    </div>
                                    <div class="pricing-body">
                                        <div class="features-section has-show-more">
                                            <h6>Includes</h6>
                                            <ul class="list-style--1 has-show-more-inner-content">
                                                <li>
                                                    <i class="fa-regular fa-circle-check"></i> Pay ₹349, Get ₹405 Value
                                                </li>
                                                <li>
                                                    <i class="fa-regular fa-circle-check"></i> +16% Bonus
                                                </li>
                                                <li>
                                                    <i class="fa-regular fa-circle-check"></i> Evaluates up to 337 pages
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pricing-footer">
                                    <a class="btn-default color-blacked" href="{{ $redirect_link }}">Get Started</a>
                                    <p class="bottom-text">Limited Offer</p>
                                </div>
                            </div>
                            <div class="feature-badge">Best Offer</div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-12 mt--40">
                        <div class="rainbow-pricing style-aiwave">
                            <div class="pricing-table-inner">
                                <div class="pricing-top">
                                    <div class="pricing-header">
                                        <div class="icon">
                                            <i class="fa-sharp fa-regular fa-waveform-lines"></i>
                                        </div>
                                        <h4 class="title color-var-three">🏆 Mains Cracker</h4>
                                        <p class="subtitle">For rigorous test series preparation</p>
                                        <div class="pricing">
                                            <span class="price-text">799</span>
                                        </div>
                                    </div>
                                    <div class="pricing-body">
                                        <div class="features-section has-show-more">
                                            <h6>Includes</h6>
                                            <ul class="list-style--1 has-show-more-inner-content">
                                                <li>
                                                    <i class="fa-regular fa-circle-check"></i> Pay ₹799, Get ₹1125 Value
                                                </li>
                                                <li>
                                                    <i class="fa-regular fa-circle-check"></i> +40% Bonus
                                                </li>
                                                <li>
                                                    <i class="fa-regular fa-circle-check"></i> Evaluates up to 937 pages
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pricing-footer">
                                    <a class="btn-default btn-border" href="{{ $redirect_link }}">Get Started</a>
                                    <p class="bottom-text">Limited Offer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-md-6 col-12 mt--40">
                        <div class="rainbow-pricing style-aiwave">
                            <div class="pricing-table-inner">
                                <div class="pricing-top">
                                    <div class="pricing-header">
                                        <div class="icon">
                                            <i class="fa-sharp fa-regular fa-waveform-lines"></i>
                                        </div>
                                        <h4 class="title color-var-three">Rank Booster</h4>
                                        <p class="subtitle">For the entire Mains season</p>
                                        <div class="pricing">
                                            <span class="price-text">1299</span>
                                        </div>
                                    </div>
                                    <div class="pricing-body">
                                        <div class="features-section has-show-more">
                                            <h6>Includes</h6>
                                            <ul class="list-style--1 has-show-more-inner-content">
                                                <li>
                                                    <i class="fa-regular fa-circle-check"></i> Pay ₹1299, Get ₹2025 Value
                                                </li>
                                                <li>
                                                    <i class="fa-regular fa-circle-check"></i> +55% Bonus
                                                </li>
                                                <li>
                                                    <i class="fa-regular fa-circle-check"></i> Evaluates up to    1687 pages
                                                </li>
                                        </div>
                                    </div>
                                </div>
                                <div class="pricing-footer">
                                    <a class="btn-default btn-border" href="{{ $redirect_link }}">Get Started</a>
                                    <p class="bottom-text">Limited Offer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="aiwave-service-area rainbow-section-gap">
    <div class="container">
        <div class="row row--15 service-wrapper">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-duration="700">
                <div class="service service__style--1 aiwave-style text-center">
                    <div class="icon">
                        <img src="{{ asset('public/images/service-icon-01.png') }}" alt="Servece Image">
                    </div>
                    <div class="content">
                        <h4 class="title w-600">No-risk. Student-friendly</h4>
                        <p class="description b1 mb--0">Evaluate 1 answer free (limited words/pages)</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-duration="700" data-sal-delay="100">
                <div class="service service__style--1 aiwave-style text-center">
                    <div class="icon">
                        <img src="{{ asset('public/images/service-icon-02.png') }}" alt="Servece Image">
                    </div>
                    <div class="content">
                        <h4 class="title w-600">Multi Language Assessment</h4>
                        <p class="description b1 mb--0">Get evaluations in Hindi & English.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-6 col-12 sal-animate" data-sal="slide-up" data-sal-duration="700" data-sal-delay="200">
                <div class="service service__style--1 aiwave-style text-center">
                    <div class="icon">
                        <img src="{{ asset('public/images/service-icon-03.png') }}" alt="Servece Image">
                    </div>
                    <div class="content">
                        <h4 class="title w-600">Instant Turnaround</h4>
                        <p class="description b1 mb--0">Feedback in minutes, not days.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="rainbow-testimonial-area rainbow-section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-left" data-sal="slide-up" data-sal-duration="400" data-sal-delay="150">
                    <h4 class="subtitle">
                        <span class="theme-gradient">Testimonials</span>
                    </h4>
                    <h2 class="title mb--60">
                        What's our users says
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="service-wrapper rainbow-service-slider-actvation slick-grid-15 rainbow-slick-dot rainbow-gradient-arrows">
                    <div class="slide-single-layout">
                        <div class="rainbow-box-card active card-style-default testimonial-style-defalt has-bg-shaped">
                            <div class="inner">
                                <div class="rating">
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                </div>
                                <div class="content">
                                    <p class="description">The instant feedback is a game-changer. I no longer have to wait days to know where I stand; I can upload my answer and get a detailed analysis in minutes, which has accelerated my learning curve massively.</p>
                                    <div class="bottom-content">
                                        <div class="meta-info-section">
                                            <p class="title-text">Priya S</p>
                                            <p class="desc">Delhi</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-shape">
                                <img src="{{ asset('public/images/bg-testimonial.png') }}" alt="" class="bg">
                                <img src="{{ asset('public/images/bg-testimonial-hover.png') }}" alt="" class="bg-hover">
                            </div>
                        </div>
                    </div>
                    <div class="slide-single-layout">
                        <div class="rainbow-box-card card-style-default testimonial-style-defalt has-bg-shaped">
                            <div class="inner">
                                <div class="rating">
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                </div>
                                <div class="content">
                                    <p class="description">
                                        The Micro-Marking Grid is brilliant. It showed me I was consistently scoring low on my conclusions, a flaw I hadn't even realized. This tool pinpoints your exact weaknesses.
                                    </p>
                                    <div class="bottom-content">
                                        <div class="meta-info-section">
                                            <p class="title-text">Rohan M</p>
                                            <p class="desc">Bangalore</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-shape">
                                <img src="{{ asset('public/images/bg-testimonial.png') }}" alt="" class="bg">
                                <img src="{{ asset('public/images/bg-testimonial-hover.png') }}" alt="" class="bg-hover">
                            </div>
                        </div>
                    </div>
                    <div class="slide-single-layout">
                        <div class="rainbow-box-card card-style-default testimonial-style-defalt has-bg-shaped">
                            <div class="inner">
                                <div class="rating">
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                </div>
                                <div class="content">
                                    <p class="description">I love the objectivity of the AI scoring. It’s consistent and unbiased, which helps me trust the feedback and focus purely on improving my content and structure for the mains.</p>
                                    <div class="bottom-content">
                                        <div class="meta-info-section">
                                            <p class="title-text">Anjali K</p>
                                            <p class="desc">Hyderabad</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-shape">
                                <img src="{{ asset('public/images/bg-testimonial.png') }}" alt="" class="bg">
                                <img src="{{ asset('public/images/bg-testimonial-hover.png') }}" alt="" class="bg-hover">
                            </div>
                        </div>
                    </div>
                    <div class="slide-single-layout">
                        <div class="rainbow-box-card active card-style-default testimonial-style-defalt has-bg-shaped">
                            <div class="inner">
                                <div class="rating">
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                </div>
                                <div class="content">
                                    <p class="description">The 'Gap Analysis' is the most valuable feature for me. The AI identifies the points and keywords I missed, and the model answers provide a clear benchmark for what a great answer looks like.</p>
                                    <div class="bottom-content">
                                        <div class="meta-info-section">
                                            <p class="title-text">Vikramjeet Singh</p>
                                            <p class="desc">Chandigarh</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-shape">
                                <img src="{{ asset('public/images/bg-testimonial.png') }}" alt="" class="bg">
                                <img src="{{ asset('public/images/bg-testimonial-hover.png') }}" alt="" class="bg-hover">
                            </div>
                        </div>
                    </div>
                    <div class="slide-single-layout">
                        <div class="rainbow-box-card card-style-default testimonial-style-defalt has-bg-shaped">
                            <div class="inner">
                                <div class="rating">
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                </div>
                                <div class="content">
                                    <p class="description">This platform has fundamentally improved my answer writing. The corrective actions are clear and actionable, helping me turn weaknesses into strengths before the actual exam.</p>
                                    <div class="bottom-content">
                                        <div class="meta-info-section">
                                            <p class="title-text">Sameera P</p>
                                            <p class="desc">Chennai</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-shape">
                                <img src="{{ asset('public/images/bg-testimonial.png') }}" alt="" class="bg">
                                <img src="{{ asset('public/images/bg-testimonial-hover.png') }}" alt="" class="bg-hover">
                            </div>
                        </div>
                    </div>
                    <div class="slide-single-layout">
                        <div class="rainbow-box-card card-style-default testimonial-style-defalt has-bg-shaped">
                            <div class="inner">
                                <div class="rating">
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                </div>
                                <div class="content">
                                    <p class="description">Before using this, my scores were stagnant. The detailed performance analytics helped me track my progress and understand how to structure my answers better to gain those crucial extra marks.</p>
                                    <div class="bottom-content">
                                        <div class="meta-info-section">
                                            <p class="title-text">Aditya G</p>
                                            <p class="desc">Pune</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-shape">
                                <img src="{{ asset('public/images/bg-testimonial.png') }}" alt="" class="bg">
                                <img src="{{ asset('public/images/bg-testimonial-hover.png') }}" alt="" class="bg-hover">
                            </div>
                        </div>
                    </div>
                    <div class="slide-single-layout">
                        <div class="rainbow-box-card card-style-default testimonial-style-defalt has-bg-shaped">
                            <div class="inner">
                                <div class="rating">
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                    <a href="#rating">
                                        <i class="fa-sharp fa-solid fa-star"></i>
                                    </a>
                                </div>
                                <div class="content">
                                    <p class="description">Being able to get multiple papers evaluated concurrently is a huge advantage. It has made my test series practice incredibly efficient and has become an indispensable part of my daily study routine.</p>
                                    <div class="bottom-content">
                                        <div class="meta-info-section">
                                            <p class="title-text">Neha Sharma</p>
                                            <p class="desc">Jaipur</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-shape">
                                <img src="{{ asset('public/images/bg-testimonial.png') }}" alt="" class="bg">
                                <img src="{{ asset('public/images/bg-testimonial-hover.png') }}" alt="" class="bg-hover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection