@extends('web.app._layout')

@section('app')
    <div class="card">
        <div class="header">
            <h1>{{ __('Cannot join group') }}</h1>
        </div>
        <div class="content">
            {{ __('This join link is not, or no longer, valid.') }}
        </div>
    </div>
@endsection
