@extends('web.app.group._layout')

@push('data') data-group="{{ $group->group_name }}" @endpush

@section('app')
    <div class="card">
        <div class="header">
            <h1>{{ __('Tally overview') }}</h1>
            <h2>{{ __('of :group_name', ['group_name' => $group->group_display_name]) }}</h2>
            <h2><br/>{{ __('Open amount: € :amount', ['amount' => number_format($total_open_amount, 2)]) }}</h2>
        </div>
        <div class="content">
            <div id="turf-overview" data-error="{{ __('Something went wrong causing the tally to not be saved.') }}">
                <x-overview-row :membership="$logged_user_membership" :bold="true"></x-overview-row>
                @foreach($members_excluding_current_viewer as $membership)
                    <x-overview-row :membership="$membership"></x-overview-row>
                @endforeach
            </div>
        </div>
    </div>
@endsection
