@extends('web._layout')

@push('wrapper-classes')
    ta:app
@endpush

@section('wrapper')
    @yield('content')
@endsection
