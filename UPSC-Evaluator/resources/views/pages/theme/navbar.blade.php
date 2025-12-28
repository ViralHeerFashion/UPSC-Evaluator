@php($institute = null)
@if(Cookie::has('institute'))
    @php($institute = json_decode(Cookie::get('institute')))
@endif
<header class="rainbow-header header-default header-transparent header-sticky">
    <div class="container position-relative">
        <div class="row align-items-center row--0">
            <div class="col-lg-2 col-md-6 col-6">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img class="logo-light" src="{{ asset('public/images/logo.png') }}" alt="Aspire Scan">
                        @if(!is_null($institute) && Storage::disk('public')->exists($institute->logo))
                        <img src="{{ Storage::disk('public')->url($institute->logo) }}" class="institute-logo">
                        @endif
                    </a>
                </div>
            </div>

            <div class="col-lg-8 d-none d-lg-block">
                <nav class="mainmenu-nav d-none d-lg-flex justify-content-center">
                    <ul class="mainmenu">
                        <li><a href="{{ route('home') }}" class="{{ Route::currentRouteName() == 'home' ? 'active' : '' }}">Home</a></li>
                        <li><a href="{{ route('about-us') }}" class="{{ Route::currentRouteName() == 'about-us' ? 'active' : '' }}">About us</a></li>
                        <li><a href="{{ route('contact-us') }}" class="{{ Route::currentRouteName() == 'contact-us' ? 'active' : '' }}">Contact us</a></li>
                        <li><a href="{{ route('home') }}#pricing">Pricing</a></li>
                    </ul>
                </nav>
            </div>

            <div class="col-lg-2 col-md-6 col-6 position-static">
                <div class="header-right">

                    <!-- Start Header Btn  -->
                    <div class="header-btn">
                        <a class="rainbow-gradient-btn" target="_blank" href="{{ route('student.login') }}"><span>Get Started</span></a>
                    </div>
                    <!-- End Header Btn  -->

                    <!-- Start Mobile-Menu-Bar -->
                    <div class="mobile-menu-bar ml--5 d-flex justify-content-end d-lg-none">
                        <div class="hamberger">
                            <button class="hamberger-button">
                                <i class="fa-sharp fa-regular fa-bars"></i>
                            </button>
                        </div>
                    </div>
                    <!-- Start Mobile-Menu-Bar -->
                </div>
            </div>
        </div>
    </div>
</header>