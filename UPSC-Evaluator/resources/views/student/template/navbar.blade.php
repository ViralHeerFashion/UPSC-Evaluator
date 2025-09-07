<header class="rbt-dashboard-header rainbow-header header-default header-left-align rbt-fluid-header">
    <div class="container-fluid position-relative">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-3 col-md-6 col-6">
                <div class="header-left d-flex">
                    <div class="expand-btn-grp">
                        <button class="bg-solid-primary popup-dashboardleft-btn"><i class="fa-sharp fa-regular fa-sidebar"></i></button>
                    </div>
                    <div class="logo">
                        <a href="{{ route('home') }}">
                            <img class="logo-light" src="{{ asset('public/images/logo.png') }}" alt="ChatBot Logo">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-none d-lg-block text-center">
                <nav class="mainmenu-nav d-none d-lg-inline-block text-center">
                    <ul class="mainmenu">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about-us') }}" class="{{ Route::currentRouteName() == 'about-us' ? 'active' : '' }}">About us</a></li>
                        <li><a href="{{ route('contact-us') }}" class="{{ Route::currentRouteName() == 'contact-us' ? 'active' : '' }}">Contact us</a></li>
                        <li><a href="{{ route('home') }}#pricing">Pricing</a></li>
                    </ul>







                </nav>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <div class="header-right">

                    <!-- Start Mobile-Menu-Bar -->
                    <!-- <div class="mobile-menu-bar ml--10 d-block d-lg-none">
                        <div class="hamberger">
                            <button class="hamberger-button">
                                <i class="fa-sharp fa-regular fa-bars"></i>
                            </button>
                        </div>
                    </div> -->
                    <!-- Start Mobile-Menu-Bar -->

                    <!-- Start Admin meta Group -->
                    <div class="rbt-admin-panel account-access rbt-user-wrapper right-align-dropdown">
                        <div class="rbt-admin-card grid-style">
                            <a class="d-flex align-items-center" href="#">
                                <div class="inner d-flex align-items-center">
                                    <div class="img-box">
                                        <img src="{{ asset('public/images/user-profile.jpg') }}" alt="Admin">
                                    </div>
                                    <div class="content">
                                        <span class="title ">{{ auth()->user()->name }}</span>
                                        <p>{{ !is_null(auth()->user()->email) ? auth()->user()->email : auth()->user()->phone }}</p>
                                    </div>
                                </div>
                                <div class="icon">
                                    <i class="fa-sharp fa-solid fa-chevron-down"></i>
                                </div>
                            </a>
                        </div>
                        <div class="rbt-user-menu-list-wrapper">
                            <div class="inner">
                                <div class="rbt-admin-profile">
                                    <div class="admin-thumbnail">
                                        <img src="{{ asset('public/images/user-profile.jpg') }}" alt="User Images">
                                    </div>
                                    <div class="admin-info">
                                        <span class="name">{{ auth()->user()->name }}</span>
                                        <a class="rbt-btn-link color-primary" href="{{ route('student.profile') }}">View Profile</a>
                                    </div>
                                </div>
                                <ul class="user-list-wrapper user-nav">
                                    <li>
                                        <a href="{{ route('student.profile') }}">
                                            <i class="fa-sharp fa-regular fa-user"></i>
                                            <span>Profile Details</span>
                                        </a>
                                    </li>
                                    {{-- 
                                    <li>
                                        <a href="notification.html">
                                            <i class="fa-sharp fa-regular fa-shopping-bag"></i>
                                            <span>Notification</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="chat-export.html">
                                            <i class="fa-sharp fa-regular fa-users"></i>
                                            <span>Chat Export</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="appearance.html">
                                            <i class="fa-sharp fa-regular fa-home"></i>
                                            <span>Apperance</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="plans-billing.html">
                                            <i class="fa-sharp fa-regular fa-briefcase"></i>
                                            <span>Plans and Billing</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="sessions.html">
                                            <i class="fa-sharp fa-regular fa-users"></i>
                                            <span>Sessions</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="application.html">
                                            <i class="fa-sharp fa-regular fa-list"></i>
                                            <span>Application</span>
                                        </a>
                                    </li>
                                </ul>
                                --}}
                                <hr class="mt--10 mb--10">
                                <ul class="user-list-wrapper">
                                    <li>
                                        <a href="{{ route('student.logout') }}">
                                            <i class="fa-sharp fa-solid fa-right-to-bracket"></i>
                                            <span>Logout</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
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
                {{-- 
                <li class="has-dropdown has-menu-child-item position-relative"><a href="#">Tools <i class="fa-regular fa-chevron-down"></i></a>
                    <ul class="submenu">
                        <li>
                            <a href="text-generator.html">
                                <span>Text Generator</span>
                            </a>
                        </li>
                        <li>
                            <a href="image-generator.html">
                                <span>Image Generator</span>
                            </a>
                        </li>
                        <li>
                            <a href="code-generator.html">
                                <span>Code Generator</span>
                            </a>
                        </li>
                        <li>
                            <a href="image-editor.html">
                                <span>Image Editor</span>
                            </a>
                        </li>
                        <li>
                            <a href="vedio-generator.html">
                                <span>Vedio Generator</span>
                            </a>
                        </li>
                        <li>
                            <a href="email-generator.html">
                                <span>Email Generator</span>
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" class="disabled" aria-disabled="true">
                                <span>Audio Generator</span>
                                <div class="rainbow-badge-card badge-sm ml--5">COMING</div>
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" class="disabled" aria-disabled="true">
                                <span>Edu. feedback</span>
                                <div class="rainbow-badge-card badge-sm ml--5">COMING</div>
                            </a>
                        </li>
                        <li>
                            <a tabindex="-1" class="disabled" aria-disabled="true">
                                <span>Website Generator</span>
                                <div class="rainbow-badge-card badge-sm ml--5">COMING</div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="with-megamenu has-menu-child-item"><a href="#">Pages <i class="fa-regular fa-chevron-down"></i></a>
                    <div class="rainbow-megamenu">
                        <div class="wrapper">
                            <div class="row row--0">
                                <div class="col-lg-3 single-mega-item">
                                    <ul class="mega-menu-item">
                                        <li>
                                            <h3 class="rbt-short-title">Inner Pages</h3>
                                        </li>
                                        <li>
                                            <a href="styleguide.html">
                                                <span>Style Guide</span>
                                                <div class="rainbow-badge-card badge-sm ml--5">Hot</div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="blog.html">
                                                <span>Blog</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="blog-details.html">
                                                <span>Blog Details</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="pricing.html">
                                                <span>Pricing</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="contact.html">
                                                <span>Contact</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="signin.html">
                                                <span>Sign In</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="signup.html">
                                                <span>Sign Up</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="Team.html">
                                                <span>Team</span>

                                            </a>
                                        </li>
                                        <li>
                                            <a href="terms-policy.html">
                                                <span>Terms & Policy</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="privacy-policy.html">
                                                <span>Privacy Policy</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-lg-3 single-mega-item">
                                    <ul class="mega-menu-item">
                                        <li>
                                            <h3 class="rbt-short-title">DASHBOARD PAGES</h3>
                                        </li>
                                        <li>
                                            <a href="profile-details.html">
                                                <span>Profile</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="notification.html">
                                                <span>Notification</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="chat-export.html">
                                                <span>Chat Export</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="appearance.html">
                                                <span>Apperance</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="plans-billing.html">
                                                <span>Plans and Billing</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="sessions.html">
                                                <span>Sessions</span>

                                            </a>
                                        </li>
                                        <li>
                                            <a href="application.html">
                                                <span>Application</span>

                                            </a>
                                        </li>
                                        <li>
                                            <a href="release-notes.html">
                                                <span>Release notes</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="help.html">
                                                <span>Help & FAQs</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-lg-3 single-mega-item">
                                    <ul class="mega-menu-item br--0">
                                        <li>
                                            <h3 class="rbt-short-title">Upcoming Advance Elements</h3>
                                        </li>
                                        <li>
                                            <a href="#" class="disabled">
                                                <span>Product Description</span>

                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="disabled">
                                                <span>Youtube Vedio to Post</span>

                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="disabled">
                                                <span>Grammar Check</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="disabled">
                                                <span>Generate From RSS</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="disabled">
                                                <span>Vedio Script</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="disabled">
                                                <span>Audio to Text</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="disabled">
                                                <span>Subscription</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="disabled">
                                                <span>Maintanence</span>

                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="disabled">
                                                <span>Coming Soon</span>

                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col-lg-3 single-mega-item">
                                    <div class="header-menu-img">
                                        <img src="images/menu-img-2.png" alt="Menu Split Image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li><a href="roadmap.html">Roadmap</a></li>
                <li><a href="utilize.html">How to use</a></li>
                --}}
            </ul>
            {{-- 
            <div class="rbt-sm-separator"></div>
            <div class="rbt-default-sidebar-wrapper">
                <nav class="mainmenu-nav">
                    <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                        <li><a href="text-generator.html"><i class="fa-sharp fa-regular fa-monitor"></i><span>Welcome</span></a></li>
                        <li><a href="plans-billing.html"><i class="fa-sharp fa-regular fa-briefcase"></i><span>Manage Subsription</span></a></li>
                    </ul>
                    <div class="rbt-sm-separator"></div>
                    <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                        <li><a href="text-generator.html"><img src="images/text.png" alt="AI Generator"><span>Text Generator</span></a></li>
                        <li><a href="image-generator.html"><img src="images/photo.png" alt="AI Generator"><span>Image Generator</span>
                                <div class="rainbow-badge-card badge-sm ml--10">Hot</div>
                            </a></li>
                        <li><a href="code-generator.html"><img src="images/code-editor.png" alt="AI Generator"><span>Code Generator</span></a></li>
                        <li><a href="image-editor.html"><img src="images/photo.png" alt="AI Generator"><span>Image Editor</span></a></li>
                        <li><a href="vedio-generator.html"><img src="images/video-camera.png" alt="AI Generator"><span>Vedio Generator</span></a></li>
                        <li><a href="email-generator.html"><img src="images/email.png" alt="AI Generator"><span>Email Generator</span></a></li>
                        <li><a tabindex="-1" class="disabled" aria-disabled="true" role="button"><img src="images/website-design.png" alt="AI Generator"><span>Website Generator</span></a></li>
                    </ul>
                </nav>

                <div class="rbt-sm-separator"></div>

                <nav class="mainmenu-nav">
                    <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                        <li class="has-submenu"><a class="collapse-btn collapsed" data-bs-toggle="collapse" href="#collapseExampleMenu" role="button" aria-expanded="false" aria-controls="collapseExampleMenu"><i class="fa-sharp fa-solid fa-circle-plus"></i><span>Setting</span></a>
                            <div class="collapse" id="collapseExampleMenu">
                                <ul class="submenu rbt-default-sidebar-list">
                                    <li>
                                        <a href="profile-details.html">
                                            <i class="fa-sharp fa-regular fa-user"></i>
                                            <span>Profile Details</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="notification.html">
                                            <i class="fa-sharp fa-regular fa-shopping-bag"></i>
                                            <span>Notification</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="chat-export.html">
                                            <i class="fa-sharp fa-regular fa-users"></i>
                                            <span>Chat Export</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="appearance.html">
                                            <i class="fa-sharp fa-regular fa-home"></i>
                                            <span>Apperance</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="plans-billing.html">
                                            <i class="fa-sharp fa-regular fa-briefcase"></i>
                                            <span>Plans and Billing</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="sessions.html">
                                            <i class="fa-sharp fa-regular fa-users"></i>
                                            <span>Sessions</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="application.html">
                                            <i class="fa-sharp fa-regular fa-list"></i>
                                            <span>Application</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="#"><i class="fa-sharp fa-regular fa-award"></i><span>Help & FAQ</span></a></li>
                    </ul>
                    <div class="rbt-sm-separator"></div>
                    <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                        <li><a href="release-notes.html"><i class="fa-sharp fa-regular fa-bell"></i><span>Release notes</span></a></li>
                        <li><a href="terms-policy.html"><i class="fa-sharp fa-regular fa-briefcase"></i><span>Terms & Policy</span></a></li>
                    </ul>
                </nav>
            </div>
            --}}
        </div>

        <!-- Start Header Btn  -->
        <div class="header-btn d-block d-md-none">
            <a class="btn-default @@btnClass" target="_blank" href="text-generator.html">Get Started Free</a>
        </div>
        <!-- End Header Btn  -->
    </div>
</div>