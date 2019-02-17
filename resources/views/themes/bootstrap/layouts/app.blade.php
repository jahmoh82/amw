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
                    <input class="form-control form-control-dark" type="text" placeholder="Search here..." aria-label="Search">
                </div>


                @if(!Auth::guest())
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav mr-auto">
                            {!! menu('authenticated-menu', 'theme::menus.bootstrap') !!}
                        </ul>
                    </div>
                @endif

                <button class="navbar-toggler @if(Auth::guest()){{ 'nonauth' }}@endif" type="button" data-toggle="collapse" data-target="#guestMenu" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                <div class="collapse navbar-collapse navbar-right" id="guestMenu">
                    <ul class="navbar-nav ml-auto">
                        @if(Auth::guest())
                            {!! menu('guest-menu', 'theme::menus.bootstrap') !!}
                            <li class="nav-login"><a href="/login">Login</a></li>
                            <li>
                                <a href="/register"><button class="btn btn-primary">Sign Up</button></a>
                            </li>
                        @else


                            @if( auth()->user()->onTrial() )
                                <li><span class="trial-days">You have {{ auth()->user()->daysLeftOnTrial() }} @if(auth()->user()->daysLeftOnTrial() > 1){{ 'Days' }}@else{{ 'Day' }}@endif left on your @if(auth()->user()->subscription('main') && auth()->user()->subscription('main')->onTrial()){{ ucfirst(auth()->user()->role->name) . ' Plan' }}@else{{ 'Free' }}@endif Trial</span></li>
                            @endif

                            @if( auth()->user()->subscribed('main') && auth()->user()->subscription('main')->onGracePeriod() && !auth()->user()->onTrial() )
                                <li><span class="trial-days">You have {{ auth()->user()->daysLeftOnGrace() }} @if(auth()->user()->daysLeftOnTrial() > 1){{ 'Days' }}@else{{ 'Day' }}@endif left on your {{ ucfirst(auth()->user()->role->name) . ' Plan' }}</span></li>
                            @endif

                            @if(!Request::is('notifications'))
                                @include('theme::partials.notifications')
                            @endif

                            <li class="dropdown user-dropdown-li">

                                <a class="nav-link dropdown-toggle user-icon" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ Voyager::image(Auth::user()->avatar) }}">
                                </a>
                                <div class="dropdown-menu user-dropdown" aria-labelledby="navbarDropdown">

                                    <div class="user-dropdown-info">
                                        <img src="{{ Voyager::image(Auth::user()->avatar) }}">
                                        <div>
                                            <p>{{ Auth::user()->name }}</p>
                                            <span>{{ Auth::user()->username }}</span>
                                        </div>
                                    </div>
                                    <div class="user-dropdown-plan text-center"><div class="badge badge-success badge-plan"  style="background:#{{ stringToColorCode(auth()->user()->role->display_name) }}">{{ auth()->user()->role->display_name }}</div></div>
                                    @if( auth()->user()->onTrial() && !auth()->user()->subscription('main') )
                                        <a href="{{ route('wave.settings', 'plans') }}" class="dropdown-item"><span uk-icon="icon: cloud-upload"></span>Upgrade My Account</a>
                                    @endif
                                    @if(Voyager::can('browse_admin'))
                                        <a href="{{ route('voyager.dashboard') }}" class="dropdown-item"><i class="fa fa-bolt"></i> Admin</a>
                                    @endif
                                    <a href="{{ route('wave.profile', Auth::user()->username) }}" class="dropdown-item"><i class="fa fa-user-o"></i> My Profile</a>
                                    <a href="{{ route('wave.settings') }}" class="dropdown-item"><i class="fa fa-cog"></i> Settings</a>
                                    <a href="{{ route('wave.notifications') }}" class="d-lg-none d-xl-none"><i class="fa fa-bell"></i> My Notifications</a>
                                    <a href="{{ route('logout') }}" class="dropdown-item"><i class="fa fa-sign-out"></i> Logout</a>

                                </div>

                            </li>

                        @endif
                    </ul>
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
