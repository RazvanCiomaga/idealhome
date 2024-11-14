<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>{{ __('IdealHome') }}</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Style CSS -->
    <link rel="stylesheet" href="style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" integrity="sha512-aD9ophpFQ61nFZP6hXYu4Q/b/USW7rpLCQLX6Bi0WJHXNO7Js/fUENpBQf/+P4NtpzNX0jSgR5zVvPOJp+W2Kg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @livewireStyles

</head>

<body>
<!-- Preloader -->
<div id="preloader">
    <div class="south-load"></div>
</div>

@php
    $agency = App\Models\Agency::query()->first();
@endphp

<!-- ##### Header Area Start ##### -->
<header class="header-area">

    <!-- Top Header Area -->
    <div class="top-header-area">
        <div class="h-100 d-md-flex justify-content-between align-items-center">
            <div class="email-address">
                <a href="{{ 'mailto:'.$agency?->email }}">{{ $agency?->email }}</a>
            </div>
            <div class="phone-number d-flex">
                <div class="icon">
                    <img src="img/icons/phone-call.png" alt="">
                </div>
                <div class="number">
                    <a href="tel:+45 677 8993000 223">{{ $agency?->phone }}</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header Area -->
    <div class="main-header-area" id="stickyHeader">
        <div class="classy-nav-container breakpoint-off">
            <!-- Classy Menu -->
            <nav class="classy-navbar justify-content-between" id="southNav">

                <!-- Logo -->
                <a class="nav-brand" href="{{ route('home') }}"><img src="img/core-img/logo.png" alt="" style="width: 20%; height: 20%;"></a>

                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>

                <!-- Menu -->
                <div class="classy-menu">

                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>

                    <!-- Nav Start -->
                    <div class="classynav row">
                        <ul>
                            <li><a href="{{ route('home') }}">{{ label('Pagina principala') }}</a></li>
                            <li><a href="{{ route('sales-listings') }}">{{ label('Pagina vanzari') }}</a></li>
                            <li><a href="{{ route('rent-listings') }}">{{ label('Pagina inchirieri') }}</a></li>
                            <li><a href="{{ route('team') }}">{{ label('Pagina echipa') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ label('Pagina contact') }}</a></li>
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>
        </div>
    </div>
</header>
<!-- ##### Header Area End ##### -->

<main>
    <div class="content">
        @yield('content')
    </div>
</main>

<!-- ##### Footer Area Start ##### -->
<footer class="footer-area section-padding-100-0 bg-img gradient-background-overlay" style="background-image: url(img/bg-img/cta.jpg);">
    <!-- Main Footer Area -->
    <div class="main-footer-area">
        <div class="container">
            <div class="row">

                <!-- Single Footer Widget -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="footer-widget-area mb-100">
                        <!-- Widget Title -->
                        <div class="widget-title">
                            <h6>{{ label('Despre noi') }}</h6>
                        </div>

                        <img src="img/bg-img/footer.jpg" alt="">
                        <div class="footer-logo my-4">
                            <img src="img/core-img/logo.png" alt="" style="height: 60%; width: 60%;">
                        </div>
                        <p>{{ label('Footer scurta descriere a agentiei.') }}</p>
                    </div>
                </div>

                <!-- Single Footer Widget -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="footer-widget-area mb-100">
                        <!-- Widget Title -->
                        <div class="widget-title">
                            <h6>{{ label('Program de lucru') }}</h6>
                        </div>
                        <!-- Office Hours -->
                        <div class="weekly-office-hours">
                            <ul>
                                <li class="d-flex align-items-center justify-content-between"><span>{{ label('Luni - Vineri') }}</span> <span>{{ $agency?->weekly_hours }}</span></li>
                                <li class="d-flex align-items-center justify-content-between"><span>{{ label('Sambata') }}</span> <span>{{ $agency?->saturday_hours }}</span></li>
                                <li class="d-flex align-items-center justify-content-between"><span>{{ label('Duminica') }}</span> <span>{{ $agency?->sunday_hours }}</span></li>
                            </ul>
                        </div>
                        <!-- Address -->
                        <div class="address">
                            <h6><img src="img/icons/phone-call.png" alt=""> {{ $agency?->phone }}</h6>
                            <h6><img src="img/icons/envelope.png" alt=""> {{ $agency?->email }}</h6>
                            <h6><img src="img/icons/location.png" alt=""> {{ $agency?->address }}</h6>
                        </div>
                    </div>
                </div>

                <!-- Single Footer Widget -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="footer-widget-area mb-100">
                        <!-- Widget Title -->
                        <div class="widget-title">
                            <h6>{{ label('Link-uri utile') }}</h6>
                        </div>
                        <!-- Nav -->
                        <ul class="useful-links-nav d-flex align-items-center">
                            <li><a href="{{ route('home') }}">{{ label('Pagina principala') }}</a></li>
                            <li><a href="{{ route('sales-listings') }}">{{ label('Pagina vanzari') }}</a></li>
                            <li><a href="{{ route('rent-listings') }}">{{ label('Pagina inchirieri') }}</a></li>
                            <li><a href="{{ route('team') }}">{{ label('Pagina echipa') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ label('Pagina contact') }}</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Single Footer Widget -->
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="footer-widget-area mb-100">
                        <!-- Widget Title -->
                        <div class="widget-title">
                            <h6>{{ label('Proprietati prezentare') }}</h6>
                        </div>
                        <!-- Featured Properties Slides -->
                        <div class="featured-properties-slides owl-carousel">
                            @php
                                $properties = \App\Models\Estate::query()->orderBy('sale_price', 'desc')->limit(3)->get();
                            @endphp

                            @foreach($properties as $property)
                                <div class="single-featured-properties">
                                    <a href="{{ route('estate.show', $property->slug) }}">
                                        <img src="{{ $property->featured_image }}" alt="">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</footer>
<!-- ##### Footer Area End ##### -->

<!-- jQuery (Necessary for All JavaScript Plugins) -->
<script src="js/jquery/jquery-2.2.4.min.js"></script>
<!-- Popper js -->
<script src="js/popper.min.js"></script>
<!-- Bootstrap js -->
<script src="js/bootstrap.min.js"></script>
<!-- Plugins js -->
<script src="js/plugins.js"></script>
<script src="js/classy-nav.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<!-- Active js -->
<script src="js/active.js"></script>
<!-- Google Maps -->
{{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAwuyLRa1uKNtbgx6xAJVmWy-zADgegA2s"></script>--}}
{{--<script src="js/map-active.js"></script>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js" integrity="sha512-4MvcHwcbqXKUHB6Lx3Zb5CEAVoE9u84qN+ZSMM6s7z8IeJriExrV3ND5zRze9mxNlABJ6k864P/Vl8m0Sd3DtQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@stack('scripts')

@livewireScripts

</body>

</html>
