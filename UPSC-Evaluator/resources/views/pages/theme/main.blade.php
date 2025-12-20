<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-style-mode" content="1">
    <link rel="icon" href="{{asset('public/images/icon.png')}}">
    <link rel="apple-touch-icon" href="{{asset('public/images/icon.png')}}">
    <title>@yield('title')</title>
    <meta name="keywords" content="UPSC answer writing, AI answer evaluation, UPSC Mains preparation, IAS exam help, check answer sheet online, Civil Services Exam, UPSC AI tool, answer writing practice, Aspire Scan">
    <meta name="description" content="Boost your UPSC Mains score with Aspire Scan. Upload your handwritten answer sheets and get instant, data-driven AI evaluation and feedback in just 120 seconds.">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://aspirescan.com<?= $_SERVER["REQUEST_URI"] ?>" />
    <meta property="og:site_name" content="Aspire Scan" />
    @include('pages.theme.styles')
    @yield('styles')
</head>
<body>
    <main class="page-wrapper">
        @include('pages.theme.navbar')
        @include('pages.theme.sidebar-mobile')

        <div class="preloader">
            <div class="loader">
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
                <div class="circle"></div>
            </div>
        </div>

        @yield('content')

        {{-- 
        @include('pages.partials.app-promotion')
        --}}
        @include('pages.theme.footer')
    </main>
    @include('pages.theme.scripts')
    @yield('scripts')
</body>
</html>