<div class="popup-mobile-menu">
    <div class="inner-popup">
        <div class="header-top">
            <div class="logo">
                <a href="index.html">
                    <img class="logo-light" src="{{ asset('public/images/logo.png') }}" alt="ChatBot Logo">
                </a>
            </div>
            <div class="close-menu">
                <button class="close-button">
                    <i class="fa-sharp fa-regular fa-x"></i>
                </button>
            </div>
        </div>

        <div class="content">
            <ul class="mainmenu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('about-us') }}">About Us</a></li>
                <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
                <li><a href="{{ route('home') }}#pricing" onclick="$('.close-button').trigger('click')">Pricing</a></li>
            </ul>

        </div>

        <!-- Start Header Btn  -->
        <div class="header-btn d-block d-md-none">
            <a class="btn-default @@btnClass" target="_blank" href="{{ route('student.login') }}">Get Start</a>
        </div>
        <!-- End Header Btn  -->
    </div>
</div>