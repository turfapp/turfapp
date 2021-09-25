@extends('web._layout')

@push('wrapper-classes') ta:auth @endpush

@section('wrapper')
    <div class="ta:header">
        <x-logo></x-logo>
    </div>
    <div class="ta:content">
        <h1>@yield('title')</h1>
        <div class="ta:flex-container">
            <div class="ta:info">
                @yield('info')
            </div>
            <div class="ta:form">
                @yield('form')
            </div>
        </div>
    </div>
@endsection
