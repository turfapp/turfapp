@extends('web.app._layout')

@section('app')
    <div class="card">
        <div class="header">
            <h1>{{ __('Deelnemen aan groep') }}</h1>
        </div>
        <div class="content">
            <div id="join-group">
                {{ __('Do you want to join the group :group_name?', ['group_name' => $group_to_join->group_display_name]) }}
                <div id="join-confirm-buttons" class="form">
                    <a class="submit" data-form="#join-group-form" href="{{ route('group.join', [$group_to_join->group_name, $group_join_code]) }}">{{ __('Join group') }}</a>
                    <a class="cancel" href="{{ route('app') }}">{{ __('Cancel') }}</a>
                </div>
                <form id="join-group-form" action="{{ route('group.join', [$group_to_join->group_name, $group_join_code]) }}" method="POST">
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
@endsection

