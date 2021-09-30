<!DOCTYPE html>
<html class="ta:dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('web._layout.head')
    </head>
    <body class="@trim @stack('body-classes') @endtrim" @trim @stack('data') @endtrim>
        @yield('body')
    </body>
</html>
