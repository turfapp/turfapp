@extends('web._layout')

@push('wrapper-classes')
    ta:auth
@endpush

@section('wrapper')
    <div class="ta:header">
        <div class="ta:logo"></div>
    </div>
    @yield('content')
@endsection
