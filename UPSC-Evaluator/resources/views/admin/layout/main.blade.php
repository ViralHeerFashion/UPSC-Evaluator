<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="icon" href="{{asset('public/images/icon.png')}}">
    <link rel="apple-touch-icon" href="{{asset('public/images/icon.png')}}">
    @include('admin.layout.style')
    @yield('styles')
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('admin.layout.topbar')
        @include('admin.layout.sidebar')
        <div class="content-wrapper">
            <div class="content">
                <div class="container-fluid">
                    @yield('content-header')
                    @yield('content')
                </div>
            </div>
        </div>
        @include('admin.layout.footer')
    </div>
    @include('admin.layout.script')
    @yield('scripts')
</body>
</html>