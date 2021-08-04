@extends('web._layout')

@push('stylesheets')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet" />
@endpush

@section('body')
    <div class="header">
        <div class="inner-header">
            <span class="logo"><a href="{{ route('index') }}">{{ config('app.name' ) }}</a></span>
        </div>
    </div>

    <div class="wrapper">
        <div class="container">
            <div class="inner-wrapper">
                <div class="content-wrapper">
                    <div class="title">
                        <p>{{ __('AN ALTERNATIVE TO PAPER TALLY LISTS') }}</p>
                    </div>
                    <div class="content">
                        <p>{{ __('Use it wherever, whenever and as much as you want. Completely for free.') }}</p>
                    </div>
                    <div class="button">
                        <a href="{{ route('app') }}"><button>{{ __('Go to the app') }}</button></a>
                    </div>
                </div>
                <div class="image-wrapper">
                    <img src="{{ asset('images/desktop.png') }}" alt="{{ __('Image showing desktop interface of TurfApp') }}" />
                </div>
            </div>
        </div>
        <div class="container">
            <div class="inner-wrapper">
                <div class="content-wrapper">
                    <div class="title">
                        <p>{{ __('DETAILED INSIGHT') }}</p>
                    </div>
                    <div class="content">
                        <p>{{ __('Get insight into when and how much is tallied.') }}</p>
                    </div>
                </div>
                <div class="image-wrapper">
                    <img src="{{ asset('images/logs.png') }}" title="{{ __('Illustration by Natasha Remarchuk from Ouch!') }}" alt="{{ __('Illustration showing a computer screen with a graph and a folder') }}; {{ __('Illustration by Natasha Remarchuk from Ouch!') }}" />
                </div>
            </div>
        </div>
        <div class="container">
            <div class="inner-wrapper">
                <div class="content-wrapper">
                    <div class="title">
                        <p>{{ __('USE IT ANYWHERE') }}</p>
                    </div>
                    <div class="content">
                        <p>{{ __('You can use the app anywhere. Both on desktop as well as on mobile.') }}</p>
                    </div>
                </div>
                <div class="image-wrapper">
                    <img src="{{ asset('images/anywhere.png') }}" title="{{ __('Illustration by Icons 8 from Ouch!') }}" alt="{{ __('Illustration showing a world map with planes and a phone') }}; {{ __('Illustration by Icons 8 from Ouch!') }}" />
                </div>
            </div>
        </div>
        <div class="container">
            <div class="inner-wrapper">
                <div class="content-wrapper">
                    <div class="title">
                        <p>{{ __('COMPLETELY FREE') }}</p>
                    </div>
                    <div class="content">
                        <p>{{ __('TurfApp can be used entirely for free, forever. No ads, no subscriptions.') }}</p>
                    </div>
                    <div class="button">
                        <a href="{{ route('app') }}"><button>{{ __('Go to the app') }}</button></a>
                    </div>
                </div>
                <div class="image-wrapper">
                    <img src="{{ asset('images/free.png') }}" title="{{ __('Illustration by Natasha Remarchuk from Ouch!') }}" alt="{{ __('Illustration showing a pale woman with a cup of coffee working with a computer') }}; {{ __('Illustration by Natasha Remarchuk from Ouch!') }}" />
                </div>
                <div class="footer">
                    &copy; {{ config('app.name') }}.nl {{ __('All Rights Reserved') }}; {{ __('Icons by') }} <a href="https://icons8.com/ouch" class="plainlink">Icons8</a>.
                </div>
            </div>
        </div>
    </div>
@endsection
