@extends('web._layout')

@section('title')
    {{ __('The free, ad-less and open-source tally system') }}
@endsection

@section('body')
    @include('web.front._layout.header')
    <div id="content" @stack('app-data')>
        @yield('content')
    </div>
@endsection
