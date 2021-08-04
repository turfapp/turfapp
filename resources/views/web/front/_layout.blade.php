@extends('web._layout')

@push('stylesheets')
    <link href="{{ asset('css/front.css') }}" rel="stylesheet" />
@endpush

@section('title')
    Het gratis, advertentieloze en open-source turfsysteem
@endsection

@section('body')
    <div class="wrapper">
        @yield('app')
    </div>
@endsection
