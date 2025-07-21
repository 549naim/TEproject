<!DOCTYPE html>
<html lang="en">

<head>
   @include('layouts.header')

</head>
<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
   
    @include('layouts.sidebar')
    @include('layouts.topbar')

    <div class="pc-container">
       @yield('content')
    </div>
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard-default.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>


</body>


</html>
