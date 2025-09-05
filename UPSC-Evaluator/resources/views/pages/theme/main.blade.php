<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-style-mode" content="1">
    <title>@yield('title')</title>
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