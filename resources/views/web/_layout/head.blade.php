<meta charset="utf-8" />
<title>{{ config('app.name') }}@hasSection('title') - @yield('title')@endif</title>
@stack('scripts-early')
<link href="{{ asset('lib/css/fontawesome.css') }}" rel="stylesheet" />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="apple-touch-fullscreen" content="yes" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="MobileOptimized" content="width" />
<meta name="HandheldFriendly" content="true" />
<meta name="keywords" content="turfapp,turf,turflijsten,digitaal turfen,digitaal streepen,streepjesapp,strepen online,studentenhuis streepjes app,turff" />
<meta name="language" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
<link rel="apple-touch-icon" sizes="180x180" href="/manifest/apple-touch-icon.png" />
<link rel="icon" type="image/png" sizes="32x32" href="/manifest/favicon-32x32.png" />
<link rel="icon" type="image/png" sizes="194x194" href="/manifest/favicon-194x194.png" />
<link rel="icon" type="image/png" sizes="192x192" href="/manifest/android-chrome-192x192.png" />
<link rel="icon" type="image/png" sizes="16x16" href="/manifest/favicon-16x16.png" />
<link rel="manifest" href="/manifest/site.webmanifest" />
<link rel="mask-icon" href="/manifest/safari-pinned-tab.svg" color="#5bbad5" />
<link rel="shortcut icon" href="/manifest/favicon.ico" />
<link href="/manifest/iphone5_splash.png" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/manifest/iphone6_splash.png" media="(device-width: 375px) and (device-height: 667px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/manifest/iphoneplus_splash.png" media="(device-width: 621px) and (device-height: 1104px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="/manifest/iphonex_splash.png" media="(device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="/manifest/iphonexr_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/manifest/iphonexsmax_splash.png" media="(device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3)" rel="apple-touch-startup-image" />
<link href="/manifest/ipad_splash.png" media="(device-width: 768px) and (device-height: 1024px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/manifest/ipadpro1_splash.png" media="(device-width: 834px) and (device-height: 1112px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/manifest/ipadpro3_splash.png" media="(device-width: 834px) and (device-height: 1194px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<link href="/manifest/ipadpro2_splash.png" media="(device-width: 1024px) and (device-height: 1366px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
<meta name="apple-mobile-web-app-title" content="TurfApp" />
<meta name="application-name" content="TurfApp" />
<meta name="msapplication-TileColor" content="#ffc40d" />
<meta name="msapplication-TileImage" content="/manifest/mstile-144x144.png" />
<meta name="msapplication-config" content="/manifest/browserconfig.xml" />
<meta name="theme-color" content="#ffffff" />
<meta name="description" content="TurfApp - Een alternatief voor papieren turflijsten" />
<meta property="og:title" content="TurfApp - Een alternatief voor papieren turflijsten" />
<meta property="og:description" content="Een alternatief voor papieren turflijsten" />
<meta property="og:type" content="website" />
<meta property="og:url" content="https://turfapp.nl" />
@stack('scripts')
@stack('stylesheets')
