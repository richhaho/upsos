<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Online & Offline marketplace that evolving buyer-seller relationships.">
    <meta name="author" content="HayCatar">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $gs->title }}</title>
    @stack('meta')
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/bootstrap-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/slick-theme.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/slick.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/nice-select.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/magnific-popup.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/custom.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/toastr.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/front/css/styles.php?color=' . str_replace('#', '', $gs->colors)) }}">
    @if ($default_font->font_value)
        <link href="https://fonts.googleapis.com/css?family={{ $default_font->font_value }}&display=swap"
            rel="stylesheet">
    @else
        <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
    @endif

    @if ($default_font->font_family)
        <link rel="stylesheet" id="colorr"
            href="{{ asset('assets/front/css/font.php?font_familly=' . $default_font->font_family) }}">
    @else
        <link rel="stylesheet" id="colorr"
            href="{{ asset('assets/front/css/font.php?font_familly=' . 'Open Sans') }}">
    @endif

    <link rel="shortcut icon" href="{{ asset('assets/images/' . $gs->favicon) }}">
    @stack('css')

    @if (!empty($seo->google_analytics))
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', '{{ $seo->google_analytics }}');
        </script>
    @endif
	<x-embed-styles />

    <style>
        .online-switcher {
            height: 2rem;
            cursor: pointer;
        }
        .online-switcher:checked {
            background-color: var(--theme-clr);
            border-color: var(--theme-clr);
        }
        .account-btn {
            margin-left: 0px !important;
        }
    </style>
</head>

<body>
{!! RecaptchaV3::initJs() !!}
    <!-- Overlayer Loader -->
    <!-- Overlayer -->

    <!-- <div id="preloader" data-image="{{ asset('assets/images/' . $gs->loader) }}"></div> -->

    <!-- Overlayer -->
    <!-- Overlayer -->

    <!-- Header -->
    <header class="{{ Route::is('front.index') ? 'header-3' : 'header-2' }} sticky_top d-flex align-items-center justify-content-center">

        @includeIf('partials.front.nav')
		
    </header>
    <!-- Header -->

    @yield('content')

    <!-- Footer -->
    @include('partials.front.footer')
    <!-- Footer -->

    @include('cookieConsent::index')



    <script src="{{ asset('assets/front/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/slick.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/notify.js') }}"></script>
    <script src="{{ asset('assets/front/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/anime.min.js') }}"></script>
    <script src="{{ asset('assets/front/js/custom.js') }}"></script>

    @php
        echo Toastr::message();
    @endphp

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6547eb17a84dd54dc488c687/1hegesl1v';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <script type="text/javascript">
        "use strict";

        let mainurl = '{{ url('/') }}';
        let tawkto = '{{ $gs->is_talkto }}';
    </script>


    <script type="text/javascript">
        "use strict";
        if (tawkto == 1) {
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/{{ $gs->talkto }}/default';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        }
    </script>
    <script>
        $(document).ready( function() {
            const userOnlineServiceStatus = "{{ $online_service_status }}";
            
            if (userOnlineServiceStatus == 1) {
                $('.online-switcher').attr('checked',true);
            }
            const changeSwitcherTitle = (el) => {
                el.attr('title', el.is(':checked') ? 'Online Service' : 'Offline Service');
            }
            

            if ($('.online-switcher').length) {
                changeSwitcherTitle($('.online-switcher'));
            }
            
            $('.online-switcher').change( function() {
                
                changeSwitcherTitle($(this));

                $.ajax({
                    url: "{{ route('front.updateOnlineServiceStatus') }}",
                    data: {online: $(this).is(':checked')},
                    method: 'POST',
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (res) => {
                        if ($('.hero-area-three').length) {
                            $('.hero-area-three').replaceWith(res.home);
                        }
                        if ($('.service-selection').length) {
                            $('.service-selection').replaceWith(res.service);
                        }
                    }
                })
            })
        });
    </script>

    @stack('js')
</body>

</html>
