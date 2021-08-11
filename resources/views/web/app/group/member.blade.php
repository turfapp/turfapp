@extends('web.app.group._layout')

@section('app')
    <div class="card">
        <div class="header member-header">
            <h1>{{ $membership->user->name }}</h1>
            <h2>{{ __('Member of') }} <a href="{{ route('group.overview', $membership->group->group_name) }}">{{ $membership->group->group_display_name }}</a></h2>
            <form id="promote-user-form" action="{{ route('group.member.promote', [$group->group_name, $membership->user->id]) }}" method="POST">
                {{ csrf_field() }}
            </form>
            <form id="demote-user-form" action="{{ route('group.member.demote', [$group->group_name, $membership->user->id]) }}" method="POST">
                {{ csrf_field() }}
            </form>
            <form id="kick-user-form" action="{{ route('group.member.kick', [$group->group_name, $membership->user->id]) }}" method="POST">
                {{ csrf_field() }}
            </form>
            <form id="reset-user-form" action="{{ route('group.member.reset', [$group->group_name, $membership->user->id]) }}" method="POST">
                {{ csrf_field() }}
            </form>
            <div class="member-awards">
                @foreach ($membership->awards as $award)
                    <div class="award">{!! $award->getAwardHTML() !!}</div>
                @endforeach
            </div>
            @if ($membership->member_is_admin)
                <div class="trophies">
                    <p>{{ __('Administrator') }}</p>
                </div>
            @endif
            <ul class="member-buttons">
                <li title="{{ __('Set outstanding tally\'s of this user to zero') }}">
                    <a href="{{ route('group.member.reset', [$group->group_name, $membership->user->id]) }}" data-form="#reset-user-form" data-confirm="{{ __('Are you sure you want to set the outstanding tally\'s of :username to zero?', ['username' => $membership->user->name]) }}">
                        <i class="fas fa-undo"></i>
                    </a>
                </li>
                @if ($logged_user_membership->member_is_admin)
                @if ($membership->member_is_admin)
                    <li title="{{ __('Demote this user to member') }}">
                        <a href="{{ route('group.member.demote', [$group->group_name, $membership->user->id]) }}" data-form="#demote-user-form">
                            <i class="fas fa-arrow-down"></i>
                        </a>
                    </li>
                @else
                    <li title="{{ __('Promote this user to administrator') }}">
                        <a href="{{ route('group.member.promote', [$group->group_name, $membership->user->id]) }}" data-form="#promote-user-form">
                            <i class="fas fa-arrow-up"></i>
                        </a>
                    </li>
                @endif
                <li title="{{ __('Kick this user') }}">
                    <a href="{{ route('group.member.kick', [$group->group_name, $membership->user->id]) }}" data-form="#kick-user-form" data-confirm="{{ __('Are you sure you want to kick :username from :group? Any unsettled tally\'s will be lost!', ['username' => $membership->user->name, 'group' => $group->group_display_name]) }}">
                        <i class="fas fa-ban"></i>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <div class="content">
            <div class="t-centered">
                <p class="t-125">{{ __('Outstanding balance') }}:</p>
                <div class="t-250">
                    <span id="currency-symbol">€</span>
                    <span id="outstanding-balance">{{ number_format($outstanding_balance, 2) }}</span>
                </div>
            </div>
            @if($log_date_groups->count() > 0)
                <x-log-overview :groups="$log_date_groups" :shown="$num_log_items_shown" :total="$num_log_items"></x-log-overview>
            @endif
        </div>
    </div>
@endsection
