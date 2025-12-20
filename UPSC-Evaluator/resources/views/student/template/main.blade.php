<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="https://aspirescan.com/public/images/icon.png">
    <link rel="apple-touch-icon" href="https://aspirescan.com/public/images/icon.png">
    <title>@yield('title')</title>
    <meta name="keywords" content="UPSC answer writing, AI answer evaluation, UPSC Mains preparation, IAS exam help, check answer sheet online, Civil Services Exam, UPSC AI tool, answer writing practice, Aspire Scan">
    <meta name="description" content="Boost your UPSC Mains score with Aspire Scan. Upload your handwritten answer sheets and get instant, data-driven AI evaluation and feedback in just 120 seconds.">
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://aspirescan.com<?= $_SERVER["REQUEST_URI"] ?>" />
    <meta property="og:site_name" content="Aspire Scan" />
    @include('student.template.style')
    @yield('style')
</head>
<body>
    <main class="page-wrapper rbt-dashboard-page">
        <div class="rbt-panel-wrapper">
            @include('student.template.navbar')
            @include('student.template.sidebar')
            <div class="rbt-main-content">
                <div class="rbt-daynamic-page-content">
                    <div class="rbt-dashboard-content">
                        @yield('tab-name')
                        <div class="content-page">@yield('content')</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <div class="rbt-progress-parent">
        <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
        </svg>
    </div>
    @include('student.template.script')
    @yield('script')
</body>
</html>
<script>
    $(document).ready(function(){
        toastr.options = {
            progressBar: true,
            showMethod: 'slideDown',
            positionClass: 'toast-top-right',
            timeOut: 5000
        };
    });
</script>