<meta charset="utf-8" />
<title>{{ config('app.name') }}@hasSection('title') - @yield('title')@endif</title>
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stack('scripts-early')
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5" />
<meta name="mobile-web-app-capable" content="yes" />
<meta name="full-screen" content="yes">
<meta name="browsermode" content="application">
<meta name="screen-orientation" content="portrait">
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="true" />
<link rel="manifest" href="{{ asset('static/manifest/site.webmanifest') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="shortcut icon" href="{{ asset('static/manifest/favicon.ico') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('static/manifest/favicon-16x16.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('static/manifest/favicon-32x32.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('static/manifest/android-chrome-192x192.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('static/manifest/apple-touch-icon-57x57.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('static/manifest/apple-touch-icon-60x60.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('static/manifest/apple-touch-icon-72x72.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('static/manifest/apple-touch-icon-76x76.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('static/manifest/apple-touch-icon-114x114.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('static/manifest/apple-touch-icon-120x120.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('static/manifest/apple-touch-icon-144x144.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('static/manifest/apple-touch-icon-152x152.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('static/manifest/apple-touch-icon-180x180.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('static/manifest/apple-touch-icon-57x57-precomposed.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon-precomposed" sizes="60x60" href="{{ asset('static/manifest/apple-touch-icon-60x60-precomposed.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('static/manifest/apple-touch-icon-72x72-precomposed.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon-precomposed" sizes="76x76" href="{{ asset('static/manifest/apple-touch-icon-76x76-precomposed.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('static/manifest/apple-touch-icon-114x114-precomposed.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon-precomposed" sizes="120x120" href="{{ asset('static/manifest/apple-touch-icon-120x120-precomposed.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('static/manifest/apple-touch-icon-144x144-precomposed.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon-precomposed" sizes="152x152" href="{{ asset('static/manifest/apple-touch-icon-152x152-precomposed.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon-precomposed" sizes="180x180" href="{{ asset('static/manifest/apple-touch-icon-180x180-precomposed.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="mask-icon" href="{{ asset('static/manifest/safari-pinned-tab.svg') }}?v=wcmPy4MLLqzcdHGNXYu8" color="#122539" />
<meta name="msapplication-TileImage" content="{{ asset('static/manifest/mstile-144x144.png') }}" />
<meta name="msapplication-config" content="{{ asset('static/manifest/browserconfig.xml') }}" />
<meta name="msapplication-TileColor" content="#ffc40d" />
<meta name="apple-mobile-web-app-title" content="TurfApp" />
<meta name="application-name" content="TurfApp" />
<meta name="theme-color" content="#122539" />
<meta name="keywords" content="turfapp,turf,turflijsten,digitaal turfen,digitaal streepen,streepjesapp,strepen online,studentenhuis streepjes app,turff" />
<meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
<meta name="description" content="TurfApp - Een alternatief voor papieren turflijsten" />
<meta property="og:title" content="TurfApp - Een alternatief voor papieren turflijsten" />
<meta property="og:description" content="Een alternatief voor papieren turflijsten" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ config('app.url') }}" />
<link href="{{ asset('static/css/main.css') }}" rel="stylesheet" crossorigin="anonymous" />
<script src="{{ asset('static/js/main.js') }}" defer="defer"></script>
@stack('scripts')
@stack('stylesheets')
