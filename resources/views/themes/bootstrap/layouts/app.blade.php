<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @if(!empty($seo->title))
        <title>{{ $seo->title }} ee</title>
    @else
        <title>{{ setting('site.title', 'Amw - Active my way') . ' - ' . setting('site.description', 'Social Playing field') }}</title>
    @endif

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge"> <!-- † -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">

    <link rel="icon" href="/favicon.png" type="image/x-icon">

    {{-- Social Share Open Graph Meta Tags --}}
    @if(isset($seo->title) && isset($seo->description) && isset($seo->image))
        <meta property="og:title" content="{{ $seo->title }}">
        <meta property="og:url" content="{{ Request::url() }}">
        <meta property="og:image" content="{{ $seo->image }}">
        <meta property="og:type" content="@if(isset($seo->type)){{ $seo->type }}@else{{ 'article' }}@endif">
        <meta property="og:description" content="{{ $seo->description }}">
        <meta property="og:site_name" content="{{ setting('site.title') }}">

        <meta itemprop="name" content="{{ $seo->title }}">
        <meta itemprop="description" content="{{ $seo->description }}">
        <meta itemprop="image" content="{{ $seo->image }}">

        @if(isset($seo->image_w) && isset($seo->image_h))
            <meta property="og:image:width" content="{{ $seo->image_w }}">
            <meta property="og:image:height" content="{{ $seo->image_h }}">
        @endif
    @endif

    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index,follow">

    @if(isset($seo->description))
        <meta name="description" content="{{ $seo->description }}">
    @endif

    <!-- Styles -->
    <link href="{{ asset('themes/bootstrap/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('themes/bootstrap/css/custom_app.css') }}" rel="stylesheet">
</head>
<body class="@if(Request::is('/')){{ 'home' }}@else{{ str_slug(str_replace('/', '-', Request::path())) }}@endif">

    <div id="app" data-sticky-wrap>

        <nav class="navbar navbar-expand-lg navbar-light bg-light @if(Request::is('/')){{ 'fixed-top' }}@endif" id="navbar">
            <div class="container">
                <a class="navbar-brand" href="/"><img src="{{ Voyager::image(theme('logo')) }}" style="height:35px;"></a>

                <div class="input-group py-1 px-2">
                    <input class="form-control form-control-dark border-right-0 " type="text" placeholder="{{ setting('site.search_placeholder')  }}" aria-label="Search">
                    <span class="input-group-append">
                        <div class="input-group-text"><i class="fa fa-search"></i></div>
                    </span>
                </div>
                <button class="navbar-toggler nonauth" type="button" data-toggle="collapse" data-target="#guestMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse navbar-right" id="guestMenu">
                    @if(Auth::guest())
                        {!! menu('guest-menu', 'theme::menus.bootstrap') !!}
                    @else
                        {!! menu('authenticated-menu', 'theme::menus.bootstrap_auth') !!}
                    @endif
                </div>
            </div>
        </nav>

        <!-- end here -->

        @yield('content')
    </div>

    <div id="footer" data-sticky-footer>

        <div class="pb-5">

            <div class="container py-5 border-top">

                <div class="row">

                    <div class="col-12 col-md mr-5 footer-content">

                        <div class="ml-2">

                            <a href="/"><img src="{{ Voyager::image(theme('footer_logo')) }}" data-src="{{ Voyager::image(theme('footer_logo')) }}" style="height:16px;"></a>

                        </div>

                        <small class="ml-2 mt-3">{{ setting('site.description', 'Social Playing field') }}</small>

                    </div>

                    <div class="col-6 col-md">

                        <h5>Site Links</h5>

                        <ul class="list-unstyled text-small">
                            <li><a href="/#features" class="text-muted" @if(Request::is('/'))@php echo 'uk-scroll="offset:80"'; @endphp@endif>Features</a></li>
                            <li><a href="/#testimonials" class="text-muted" @if(Request::is('/'))@php echo 'uk-scroll="offset:80"'; @endphp@endif>Testimonials</a></li>
                            <li><a href="/#pricing" class="text-muted" @if(Request::is('/'))@php echo 'uk-scroll="offset:80"'; @endphp@endif>Pricing</a></li>
                        </ul>

                    </div>

                    <div class="col-6 col-md">

                        <h5>Wave Resources</h5>

                        <ul class="list-unstyled text-small">
                            <li><a href="https://devdojo.com/scripts/php/wave" class="text-muted" target="_blank">Product Page</a></li>
                            <li><a href="/docs" class="text-muted">Documentation</a></li>
                            <li><a href="https://devdojo.com/series/wave" class="text-muted" target="_blank">Videos</a></li>
                        </ul>

                    </div>

                    <div class="col-6 col-md">

                        <h5>Contact Us</h5>

                        <div class="uk-margin">info@activemyway.com</div>

                </div>


            </div>
        </div>
    </div>

    @if(!auth()->guest() && auth()->user()->hasAnnouncements())
        @include('theme::partials.announcements')
    @endif

    <!-- Scripts -->
    <script src="{{ asset('themes/bootstrap/js/app.js') }}"></script>
    <script src="{{ asset('themes/bootstrap/js/custom_app.js') }}"></script>

    @yield('javascript')

    @impersonating
        @include('theme::partials.impersonation-bar')
    @endImpersonating

    <script>
        @if(session('message'))
            @php
                switch ( session('message_type') ) {
                    case 'info':
                        @endphp toastr.info('{{ session("message") }}'); @php
                        break;
                    case 'success':
                        @endphp toastr.success('{{ session("message") }}'); @php
                        break;
                    case 'warning':
                        @endphp toastr.warning('{{ session("message") }}'); @php
                        break;
                    case 'danger':
                        @endphp toastr.danger('{{ session("message") }}'); @php
                        break;
                }
            @endphp
        @endif
    </script>

    @if(setting('site.google_analytics_tracking_id', ''))
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-62970618-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '{{ setting("site.google_analytics_tracking_id") }}');
        </script>

    @endif
</body>
</html>
