@extends('pages.theme.main')
@section('title', 'Contact US')
@section('styles')
<style>
    .rainbow-address{margin: 0 0 30px 0!important;}
    .border-radius{border-radius: 10px;margin-bottom: 10px;}
    .custom-margin-top{
        margin-top: 20px!important;
    }
    @media only screen and (max-width: 425px) {
        .custom-margin-top{
            margin-top: 55px!important;
        }
    }
</style>
@endsection
@section('content')
<div class="rainbow-cta-area rainbow-section-gap rainbow-section-gapBottom-big">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="content-page pb--50 mt-3">
                    <div class="rainbow-accordion-style accordion rainbow-section-gapBottom">
                        <div class="banner-area custom-margin-top">
                            <div class="settings-area">
                                <h3 class="title">Contact us</h3>
                            </div>
                            <div class="row mt--40 row--15">
                                <div class="col-lg-8">
                                    <div class="contact-details-box">
                                        <div class="profile-details-tab">
                                            <div class="tab-content">
                                                @if(Session::has('success'))
                                                <div class="alert alert-success border-radius alert-dismissible fade show" role="alert">
                                                    <strong>Congratulations!</strong> Message send successfully. out team will reach you.
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                                @endif
                                                <div class="tab-pane fade active show" id="image-genarator" role="tabpanel">
                                                    <form action="{{ route('contact-us.create') }}" method="post" class="rbt-profile-row rbt-default-form row row--15">
                                                        @csrf
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                            <div class="form-group">
                                                                <label for="first_name">First Name</label>
                                                                <input id="first_name" type="text" name="first_name" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                            <div class="form-group">
                                                                <label for="last_name">Last Name</label>
                                                                <input id="last_name" type="text" name="last_name" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                            <div class="form-group">
                                                                <label for="phone">Phone</label>
                                                                <input id="phone" type="tel" name="phone" pattern="^\d{10}$" maxlength="10" title="Enter valid phone number">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input id="email" type="email" name="email" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="message">Message</label>
                                                                <textarea id="message" name="message" cols="20" rows="5" placeholder="Type your message here..." required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt--20">
                                                            <div class="form-group mb--0">
                                                                <button type="submit" class="btn-default">Submit</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 mt_md--30 mt_sm--30">
                                    <div class="rainbow-address">
                                        <div class="icon">
                                            <i class="fa-sharp fa-regular fa-location-dot"></i>
                                        </div>
                                        <div class="inner">
                                            <h4 class="title">Location</h4>
                                            <p class="b2">100 avenue of the moon, 12 new <br> York, ny 1001B US.</p>
                                        </div>
                                    </div>
                                    <div class="rainbow-address">
                                        <div class="icon">
                                            <i class="fa-sharp fa-solid fa-headphones"></i>
                                        </div>
                                        <div class="inner">
                                            <h4 class="title">Contact Number</h4>
                                            <p class="b2"><a href="#">+444 555 666 777</a></p>
                                            <p class="b2"><a href="#">+222 222 222 333</a></p>
                                        </div>
                                    </div>
                                    <div class="rainbow-address">
                                        <div class="icon">
                                            <i class="fa-sharp fa-regular fa-envelope"></i>
                                        </div>
                                        <div class="inner">
                                            <h4 class="title">Our Email Address</h4>
                                            <p class="b2"><a href="mailto:admin@gmail.com">admin@gmail.com</a></p>
                                            <p class="b2"><a href="mailto:example@gmail.com">example@gmail.com</a></p>
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
@endsection
@section('scripts')
<script>
    $(document).ready(function(){});
</script>
@endsection