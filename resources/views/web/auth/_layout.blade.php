@extends('web._layout')

@push('stylesheets')
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" />
@endpush

@section('body')
    <div id="app">
        @yield('app')
    </div>
@endsection
