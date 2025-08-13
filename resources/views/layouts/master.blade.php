<!DOCTYPE html>
<html lang="en">

<head>
     <title>{{ config('app.name', 'MBSTU') }}</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <link rel="icon" href="{{ asset('assets/images/iqac.png') }}" type="image/x-icon">


    @include('layouts.header')

</head>

<body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">

    @include('layouts.sidebar')
    @include('layouts.topbar')

    <div class="pc-container">
        @yield('content')
    </div>
    <div class="pc-footer d-flex justify-content-center align-items-center">
        <div class="pc-footer-wrapper">
            <div class="pc-footer-content text-center">
                <span class="text-muted text-center">
                    © {{ date('Y') }}  All rights reserved <br> <a href="" target="">Institutional Quality Assurance Cell (IQAC), MBSTU</a>
                </span>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('js/message-modal.js') }}"></script>

</body>


</html>
