@extends('web.app._layout')

@push('sidebar')
    <a class="item @if(Route::is('group.overview')) active @endif" href="{{ route('group.overview', $group->group_name) }}">
        <i class="fas fa-home icon icon"></i> <span class="text">{{ $group->group_display_name }}</span>
    </a>
    <div class="menu">
        <a class="item @if(Route::is('group.overview')) active @endif" href="{{ route('group.overview', $group->group_name) }}">
            <i class="fas fa-list icon"></i> <span class="text">{{ __('Overview') }}</span>
        </a>
        <a class="item @if(Route::is('group.logs')) active @endif" href="{{ route('group.logs', $group->group_name) }}">
            <i class="fas fa-book icon"></i> <span class="text">{{ __('Logs') }}</span>
        </a>
        <a class="item @if(Route::is('group.add')) active @endif" href="{{ route('group.add', $group->group_name) }}">
            <i class="fas fa-user-plus icon"></i> <span class="text">{{ __('Invite people') }}</span>
        </a>
        <a class="item @if(Route::is('group.stocktaking') || Route::is('group.stocktaking.edit')) active @endif" href="{{ route('group.stocktaking', $group->group_name) }}">
            <i class="fas fa-dolly-flatbed icon"></i> <span class="text">{{ __('Stocktaking') }}</span>
        </a>
        @if(isset($logged_user_membership) && $logged_user_membership instanceof \App\Models\Membership && $logged_user_membership->member_is_admin)
            <a class="item @if(Route::is('group.settings')) active @endif" href="{{ route('group.settings', $group->group_name) }}">
                <i class="fas fa-cog icon"></i> <span class="text">{{ __('Group settings') }}</span>
            </a>
        @endif
        <a class="item" data-form="#leave-group-form" data-confirm="{{ __("Are you sure you want to leave the group \":group\"?", [ 'group' => $group->group_display_name ]) }}" href="{{ route('group.leave', $group->group_name) }}">
            <i class="fas fa-sign-out-alt icon"></i> <span class="text">{{ __('Leave group') }}</span>
        </a>
    </div>
    <form id="leave-group-form" action="{{ route('group.leave', $group->group_name) }}" method="POST">
        {{ csrf_field() }}
    </form>
@endpush
