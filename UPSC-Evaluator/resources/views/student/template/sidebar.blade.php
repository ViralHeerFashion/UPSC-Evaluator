<div class="rbt-left-panel popup-dashboardleft-section">
    <div class="rbt-default-sidebar">
        <div class="inner">
            <div class="content-item-content">
                <div class="rbt-default-sidebar-wrapper">
                    <nav class="mainmenu-nav">
                        <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                            <!-- <li>
                                <a href="javascript:void(0);"><img src="/images/text.png" alt="AI Generator"><span>Text Generator</span></a>
                            </li> -->
                            <li><a href="{{ route('student.mains-evaluation') }}" class="answer-evaluation"><img src="{{ asset('public/images/photo.png') }}" alt="Question paper evaluation"><span>Answer Evaluation</span></a></li>
                            <li><a href="{{ route('student.recharge') }}" class="wallet-recharge"><img src="{{ asset('public/images/wallet-recharge.png') }}" alt="Wallet Recharge"><span>Recharge</span></a></li>
                            <li><a href="{{ route('student.mains-evaluation.list') }}" class="past-evaluation"><img src="{{ asset('public/images/past-evaluations.png') }}" alt="Past Evaluation"><span>Past Evaluation</span></a></li>
                            {{-- 
                            <li><a href="javascript:void(0);"><img src="/images/photo.png" alt="AI Generator"><span>Image Generator</span>
                                    <div class="rainbow-badge-card badge-sm ml--10">NEW</div>
                                </a></li>
                            <li><a href="javascript:void(0);"><img src="/images/code-editor.png" alt="AI Generator"><span>Code Generator</span></a></li>
                            <li><a href="javascript:void(0);"><img src="/images/photo.png" alt="AI Generator"><span>Image Editor</span></a></li>
                            <li><a href="javascript:void(0);"><img src="/images/video-camera.png" alt="AI Generator"><span>Vedio Generator</span></a></li>
                            <li><a href="javascript:void(0);"><img src="/images/email.png" alt="AI Generator"><span>Email Generator</span></a></li>
                            <li><a tabindex="-1" class="disabled" aria-disabled="true"><img src="/images/website-design.png" alt="AI Generator"><span>Website Generator</span>
                                    <div class="rainbow-badge-card badge-sm ml--10">PRO</div>
                                </a></li>
                            --}}
                        </ul>
                    </nav>

                    <div class="rbt-sm-separator"></div>

                    <nav class="mainmenu-nav">
                        <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                            <li class="has-submenu"><a class="collapse-btn collapsed" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa-sharp fa-solid fa-circle-plus"></i><span>Setting</span></a>
                                <div class="collapse" id="collapseExample">
                                    <ul class="submenu rbt-default-sidebar-list">
                                        <li>
                                            <a href="{{ route('student.profile') }}">
                                                <i class="fa-sharp fa-regular fa-user"></i>
                                                <span>Profile Details</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('student.profile.security') }}">
                                                <i class="fa-sharp fa-regular fa-shopping-bag"></i>
                                                <span>Security</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li><a href="{{ route('faq') }}"><i class="fa-sharp fa-regular fa-award"></i><span>FAQ</span></a></li>
                        </ul>
                        <div class="rbt-sm-separator"></div>
                        <ul class="dashboard-mainmenu rbt-default-sidebar-list">
                            <li><a href="{{ route('disclaimer') }}"><i class="fa-sharp fa-regular fa-bell"></i><span>Disclaimer</span></a></li>
                            <li><a href="{{ route('privacy-policy') }}"><i class="fa-sharp fa-regular fa-briefcase"></i><span>Terms & Condition</span></a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        {{-- 
        <div class="subscription-box">
            <div class="inner">
                <a href="profile-details.html" class="autor-info">
                    <div class="author-img active">
                        <img class="w-100" src="/images/team-01sm.jpg" alt="Author">
                    </div>
                    <div class="author-desc">
                        <h6>Adam Milner</h6>
                        <p>trentadam@net</p>
                    </div>
                    <div class="author-badge">Free</div>
                </a>
                <div class="btn-part">
                    <a href="pricing.html" class="btn-default btn-border">Upgrade To Pro</a>
                </div>
            </div>
        </div>
        <p class="subscription-copyright copyright-text text-center b3  small-text">© <script>document.write(new Date().getFullYear());</script> <a href="https://themeforest.net/user/pixcelsthemes">Pixcels Themes</a>.</p>
         --}}
    </div>
</div>