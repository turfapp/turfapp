@extends('web._layout')

@section('body')
    <div class="uk-navbar-container uk-navbar-transparent" uk-navbar="uk-navbar">
        <div class="uk-navbar-center">
            <a href="{{ route('index') }}" class="uk-navbar-item uk-logo"></a>
        </div>
    </div>
    <div id="app">
        @yield('app')
    </div>
@endsection
