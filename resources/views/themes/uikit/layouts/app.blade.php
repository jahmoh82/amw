<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    @if(isset($seo->title))
        <title>{{ $seo->title }}</title>
    @else
        <title>{{ setting('site.title', 'Amw - Active my way') . ' - ' . setting('site.description', 'Social Playing field') }}</title>
    @endif

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge"> <!-- † -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">

    <link rel="icon" href="/wave/favicon.png" type="image/x-icon">

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
        <link href="{{ asset('themes/uikit/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('themes/uikit/css/custom_app.css') }}" rel="stylesheet">
</head>
<body class="@if(Request::is('/')){{ 'home' }}@else{{ str_slug(str_replace('/', '-', Request::path())) }}@endif">
    <div id="app" data-sticky-wrap>

        <div class="uk-nav-container" @if(Request::is('/')){{ 'uk-sticky' }}@endif>
            <div class="uk-container">
                <nav class="uk-navbar-container uk-margin uk-navbar-transparent" uk-navbar>
                    <div class="uk-navbar-left uk-logo-container">
                        <a class="uk-navbar-item uk-logo" href="/"><img src="{{ Voyager::image(theme('logo')) }}" style="height:35px;"></a>
                    </div>

                    @if(!Auth::guest())
                        <div id="uk-nav-left-mobile"><span class="more-btn" uk-icon="menu"></span><span class="close-btn uk-icon" uk-icon="close"></span></div>
                        <div class="uk-navbar-left uk-margin-left">
                            <ul class="uk-navbar-nav" id="uk-nav-left">
                                {!! menu('authenticated-menu', 'theme::menus.uikit') !!}
                            </ul>
                        </div>
                    @endif

                    <div class="uk-navbar-right">

                        <ul class="uk-navbar-nav @if(!Auth::guest()){{ 'uk-navbar-auth' }}@endif" id="uk-nav-right">
                            @if(Auth::guest())
                                {!! menu('guest-menu', 'theme::menus.uikit') !!}
                                <li class="uk-login"><a href="/login">Login</a></li>
                                <li>
                                    <a href="/register"><button class="uk-button uk-button-primary">Sign Up</button></a>
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

                                <li>
                                    <a href="#_" class="user-icon">
                                        <img src="{{ Voyager::image(Auth::user()->avatar) }}">
                                        <span uk-icon="icon: triangle-down"></span>
                                    </a>
                                    <div class="uk-navbar-dropdown uk-user-dropdown" id="user-dropdown">
                                        <ul class="uk-nav uk-navbar-dropdown-nav">
                                            <li class="user-dropdown-info">
                                                <img src="{{ Voyager::image(Auth::user()->avatar) }}">
                                                <div>
                                                    <p>{{ Auth::user()->name }}</p>
                                                    <span>{{ Auth::user()->username }}</span>
                                                </div>
                                            </li>
                                            <li><div class="uk-label uk-label-success uk-label-plan"  style="background:#{{ stringToColorCode(auth()->user()->role->display_name) }}">{{ auth()->user()->role->display_name }}</div></li>
                                            @if( auth()->user()->onTrial() && !auth()->user()->subscription('main') )
                                                <li><a href="{{ route('wave.settings', 'plans') }}"><span uk-icon="icon: cloud-upload"></span>Upgrade My Account</a></li>
                                            @endif
                                            @if(Voyager::can('browse_admin'))
                                                <li><a href="{{ route('voyager.dashboard') }}"><span uk-icon="icon: bolt"></span>Admin</a></li>
                                            @endif
                                            <li><a href="{{ route('wave.profile', Auth::user()->username) }}"><span uk-icon="icon: user"></span>My Profile</a></li>
                                            <li><a href="{{ route('wave.settings') }}"><span uk-icon="icon: cog"></span>Settings</a></li>
                                            <li class="uk-hidden@m"><a href="{{ route('wave.notifications') }}"><span uk-icon="icon: bell"></span>My Notifications</a></li>
                                            <li><a href="{{ route('logout') }}"><span uk-icon="icon: sign-out"></span>Logout</a></li>
                                        </ul>
                                    </div>
                                </li>

                            @endif
                        </ul>
                        <div id="uk-nav-right-mobile"><span class="more-btn" uk-icon="more-vertical"></span><span class="close-btn uk-icon" uk-icon="close"></span></div>
                    </div>

                </nav>
            </div>
        </div>

        @yield('content')
    </div>

    <div id="footer" data-sticky-footer>

        <div class="uk-section-default uk-section uk-section-large">

            <div class="uk-container">

                <div class="uk-grid-large uk-grid-margin-large uk-grid" uk-grid="">

                    <div class="uk-width-expand@m uk-width-1-2@s uk-first-column uk-footer-logo">

                        <div class="uk-margin">

                            <a href="/"><img src="{{ Voyager::image(theme('footer_logo')) }}" data-src="{{ Voyager::image(theme('footer_logo')) }}" style="height:16px;"></a>

                        </div>

                        <div class="uk-margin uk-width-xlarge">{{ setting('site.description', 'Social Playing field') }}</div>

                    </div>

                    <div class="uk-width-expand@m uk-width-1-2@s">

                        <h3 class="uk-h5">Site Links</h3>

                        <ul class="uk-list">
                            <li><a href="/#features" class="uk-link-muted" @if(Request::is('/'))@php echo 'uk-scroll="offset:80"'; @endphp@endif>Features</a></li>
                            <li><a href="/#testimonials" class="el-link uk-link-muted" @if(Request::is('/'))@php echo 'uk-scroll="offset:80"'; @endphp@endif>Testimonials</a></li>
                            <li><a href="/#pricing" class="el-link uk-link-muted" @if(Request::is('/'))@php echo 'uk-scroll="offset:80"'; @endphp@endif>Pricing</a></li>
                        </ul>

                    </div>

                    <div class="uk-width-expand@m uk-width-1-2@s">

                        <h3 class="uk-h5">Wave Resources</h3>

                        <ul class="uk-list">
                            <li><a href="https://devdojo.com/scripts/php/wave" class="el-link uk-link-muted" target="_blank">Product Page</a></li>
                            <li><a href="/docs" class="el-link uk-link-muted">Documentation</a></li>
                            <li><a href="https://devdojo.com/series/wave" class="el-link uk-link-muted" target="_blank">Videos</a></li>
                        </ul>

                    </div>

                    <div class="uk-width-expand@m uk-width-1-2@s">

                        <h3 class="uk-h5">Contact Us</h3>

                        <div class="uk-margin">info@activemyway.com</div>

                        <div class="uk-margin">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if(!auth()->guest() && auth()->user()->hasAnnouncements())
        @include('theme::partials.announcements')
    @endif

    <!-- Scripts -->
    <script src="{{ asset('themes/uikit/js/app.js') }}"></script>
    <script src="{{ asset('themes/uikit/js/custom_app.js') }}"></script>

    @yield('javascript')

    @impersonating
        @include('theme::partials.impersonation-bar')
    @endImpersonating

    <script>
        @if(session('message'))
            @php $message_type = (session('message_type') == 'info') ? 'primary' : session('message_type'); @endphp
            UIkit.notification('{{ session("message") }}', {status:'{{ $message_type }}', pos: 'top-right'})
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
