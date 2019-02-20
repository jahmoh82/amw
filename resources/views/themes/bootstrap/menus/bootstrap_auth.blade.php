@if(!isset($innerLoop))
<ul class="navbar-nav mr-auto">
@else
<ul class="dropdown-menu">
@endif

@php

    if (Voyager::translatable($items)) {
        $items = $items->load('translations');
    }

@endphp

@foreach ($items as $item)

    @php

        $originalItem = $item;
        if (Voyager::translatable($item)) {
            $item = $item->translate($options->locale);
        }

        $listItemClass = null;
        $linkAttributes =  null;
        $styles = null;
        $icon = null;
        $caret = null;

        // Background Color or Color
        if (isset($options->color) && $options->color == true) {
            $styles = 'color:'.$item->color;
        }
        if (isset($options->background) && $options->background == true) {
            $styles = 'background-color:'.$item->color;
        }

        $linkAttributes =  'class="nav-link"';


        // With Children Attributes
        if(!$originalItem->children->isEmpty()) {
            $linkAttributes =  'class="dropdown-toggle nav-link" data-toggle="dropdown"';
            $caret = '<span class="caret"></span>';

            if(url($item->link()) == url()->current()){
                $listItemClass = 'dropdown active';
            }else{
                $listItemClass = 'dropdown';
            }
        }

        // Set Icon
        if(isset($options->icon) && $options->icon == true){
            $icon = '<i class="' . $item->icon_class . '"></i>';
        }

        if(isset($innerLoop)):
            $linkAttributes =  'class="dropdown-item"';
        endif;

    @endphp
    <li class="{{ $listItemClass }} nav-item{{ Request::is(str_replace('/', '', $item->link()).'*') ? ' active' : '' }}">
        <a href="{{ url($item->link()) }}" target="{{ $item->target }}" style="{{ $styles }}" {!! isset($linkAttributes) ? $linkAttributes : '' !!}>
            {!! $icon !!}
            <span>{{ $item->title }}</span>
            {!! $caret !!}
        </a>
        @if(!$originalItem->children->isEmpty())
            @include('theme::menus.bootstrap', ['items' => $originalItem->children, 'options' => $options, 'innerLoop' => true])
        @endif
    </li>
@endforeach


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
</ul>
