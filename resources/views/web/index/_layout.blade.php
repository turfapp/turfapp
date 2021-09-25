@extends('web._layout')

@section('title')
    {{ __('The free, ad-less and open-source tally system') }}
@endsection

@push('wrapper-classes') ta:index @endpush

@section('wrapper')
    @yield('content')
@endsection
