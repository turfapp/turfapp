<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('web._layout.head')
    </head>
    <body class="ta:dark" @stack('data')>
        <div id="wrapper" class="@stack('wrapper-classes')" @stack('wrapper-data')>
            @yield('wrapper')
        </div>
    </body>
</html>
