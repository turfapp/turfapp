@extends('web._layout')

@push('stylesheets')
    <link href="{{ asset('css/front.css') }}" rel="stylesheet" />
@endpush

@section('title')
    Het gratis, advertentieloze en open-source turfsysteem
@endsection

@section('body')
    @include('web.front._layout.header')
    <div id="content" @stack('app-data')>
        @yield('content')
    </div>
@endsection
