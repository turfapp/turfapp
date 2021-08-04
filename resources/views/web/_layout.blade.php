<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('web._layout.head')
    </head>
    <body @stack('data')>
        @include('web._layout.body')
    </body>
</html>
