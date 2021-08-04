@extends('web._layout')

@push('scripts')
    <script src="{{ asset('js/app.js') }}" defer="defer"></script>
@endpush

@push('stylesheets')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
@endpush

@section('body')
    @include('web.app._layout.sidebar')
    <div id="main">
        @if(!empty(session()->get('error')))
            <div class="error">
                {{ session()->get('error') }}
            </div>
        @endif
        @if(!empty(session()->get('success')))
            <div class="success">
                {{ session()->get('success') }}
            </div>
        @endif
        @include('web.app._layout.mobile-sidebar')
        <div id="app" @stack('app-data')>
            @yield('app')
        </div>
    </div>
@endsection
