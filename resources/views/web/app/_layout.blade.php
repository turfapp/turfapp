@extends('web._layout')

@section('body')
    @include('web.app._layout.sidebar')
    <div id="main">
        @if(!empty(session()->get('error')))
            <!-- TODO -->
        @endif
        @if(!empty(session()->get('success')))
            <!-- TODO -->
        @endif
        @include('web.app._layout.mobile-sidebar')
        <div id="app" @stack('app-data')>
            @yield('app')
        </div>
    </div>
@endsection
