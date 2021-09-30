@extends('web._layout')

@push('body-classes') ta:auth @endpush

@section('body')
    <header>
        <x-logo></x-logo>
    </header>
    <main>
        <h2>@yield('title')</h2>
        <div class="ta:flex">
            <div class="ta:info">
                <p>{{ __('TurfApp is the free, ad-less and open-source tally system. It is the ideal help in consumption management.') }}</p>
                <p>{{ __('This free and ad-less service has been developed to keep track of drink stock and consumption. Indispensable in any student house or office.') }}</p>
                <p>{{ __('By signing up for and signing in to this service you accept our:') }}</p>
                <ul>
                    <li><a href="{{ route('privacy') }}">{{ __("Our privacy policy") }}</a></li>
                    <li><a href="{{ route('terms') }}">{{ __("TurfApp.nl Terms") }}</a>.</li>
                </ul>
            </div>
            <div class="ta:form">
                test
                @yield('form')
            </div>
        </div>
    </main>
    <footer>
        <ul>
            <li><a href="{{ route('about') }}">{{ __('About TurfApp') }}</a></li>
            <li><a href="{{ route('about') }}">{{ __('About TurfApp') }}</a></li>
        </ul>
    </footer>
@endsection
