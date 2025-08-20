<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
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
            timeOut: 2000
        };
    });
</script>