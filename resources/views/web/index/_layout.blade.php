@extends('web._layout')

@section('title')
    {{ __('The free, ad-less and open-source tally system') }}
@endsection

@section('body')
    <div id="content" @stack('app-data')>
        @yield('app')
    </div>
@endsection
