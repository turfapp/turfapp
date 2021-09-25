<!-- Functional tags -->
<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>{{ config('app.name') }}@hasSection('title') - @yield('title')@endif</title>
<!-- Interface tags -->
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
<link rel="icon" type="image/svg+xml" href="{{ asset('static/manifest/favicon.svg') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('static/manifest/favicon-16x16.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('static/manifest/favicon-32x32.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('static/manifest/apple-touch-icon-180x180.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="apple-touch-icon-precomposed" sizes="180x180" href="{{ asset('static/manifest/apple-touch-icon-180x180-precomposed.png') }}?v=wcmPy4MLLqzcdHGNXYu8" />
<link rel="mask-icon" href="{{ asset('static/manifest/safari-pinned-tab.svg') }}?v=wcmPy4MLLqzcdHGNXYu8" color="#122539" />
<meta name="msapplication-TileImage" content="{{ asset('static/manifest/mstile-144x144.png') }}" />
<meta name="msapplication-config" content="{{ asset('static/manifest/browserconfig.xml') }}" />
<meta name="msapplication-TileColor" content="#ffc40d" />
<meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}" />
<meta name="application-name" content="{{ config('app.name') }}" />
<meta name="theme-color" content="#122539" />
<!-- Meta data tags -->
<meta name="keywords" content="turfapp,turf,turflijsten,digitaal turfen,digitaal streepen,streepjesapp,strepen online,studentenhuis streepjes app,turff" />
<meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
<meta name="description" content="{{ config('app.name') }}@hasSection('title') - @yield('title')@endif" />
<!-- Open Graph tags -->
<meta property="og:title" content="{{ config('app.name') }}@hasSection('title') - @yield('title')@endif" />
<meta property="og:description" content="{{ __('The free, ad-less and open-source tally system') }}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{ config('app.url') }}" />
<meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
<meta property="og:site_name" content="{{ config('app.name') }}" />
<!-- Scripts and links -->
<link href="{{ asset('static/css/main.css') }}" rel="stylesheet" crossorigin="anonymous" />
<script src="{{ asset('static/js/main.js') }}" defer="defer"></script>
@stack('scripts')
@stack('stylesheets')
