@extends('web.front._layout')

@section('content')
    <section class="dark">
        <div class="wrapper">
            <div class="left">
                <h1>Het gratis, advertentieloze en open-source turfsysteem</h1>
                <p>TurfApp is hét gratis en open-source alternatief voor papieren turflijsten. Gebruik het overal.</p>
            </div>
            <div class="right">
                <img id="desktop" src="{{ asset('images/desktop.png') }}" alt="Screenshot die het streepjesoverzicht van de applicatie laat zien" />
            </div>
        </div>
    </section>
    <footer>
        <p>&copy; {{ config('app.name') }}.nl {{ __('All Rights Reserved') }}</p>
        <p><a href="https://github.com/turfapp/turfapp"><i class="fab fa-github"></i></a></p>
    </footer>
@endsection
