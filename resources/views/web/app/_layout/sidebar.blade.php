<div id="sidebar">
    <div id="mobile-menu-close"><i class="fas fa-times"></i></div>
    <div class="logo"><a href="{{ route('app') }}">{{ config('app.name' ) }}</a></div>
    <hr/>
    <p class="welcome">{{ $logged_user->name }}</p>
    <div class="menu">
        @stack('sidebar')
        <div class="item"><i class="fas fa-user-friends icon"></i> <span class="text">{{ __('Groups') }}</span></div>
        <div class="menu">
            @foreach ($logged_user->memberships_sorted as $membership)
                <a class="item @if(request()->route('groupname') === $membership->group->group_name) active @endif" href="{{ route('group.overview', $membership->group->group_name) }}"><span class="icon">{{ mb_strtoupper( mb_substr( $membership->group->group_display_name, 0, 1 ) ) }}</span> <span class="text">{{ $membership->group->group_display_name }}</span></a>
            @endforeach
            <a class="item @if(Route::is('groups.new')) active @endif" href="{{ route('groups.new') }}"><i class="fas fa-plus icon"></i> <span class="text">{{ __('New group') }}</span></a>
        </div>
        <a class="item" href="{{ route('logout') }}" data-form="#logout-form"><i class="fas fa-sign-out-alt icon"></i> <span class="text">{{ __('Logout') }}</span></a>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        {{ csrf_field() }}
    </form>
</div>
