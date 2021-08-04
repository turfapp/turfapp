@extends('web.app.group._layout')

@section('app')
    <div class="card">
        <div class="header">
            <h1>{{ __('Joint log') }}</h1>
        </div>
        <div class="content">
            <x-log-overview :groups="$log_date_groups" :shown="$num_log_items_shown" :total="$num_log_items"></x-log-overview>
        </div>
    </div>
@endsection
