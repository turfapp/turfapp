@extends('web.app._layout')

@push('app-data')
    class="empty"
@endpush

@section('app')
    <div class="d-flex flex-center w-full h-full">
        <div class="c-grey">
            <i id="icon-welcome" class="fas fa-glass-cheers t-400"></i>
            <p class="with-margin t-125">{{ __('Welcome') }}, {{ $logged_user->first_name }}</p>
        </div>
    </div>
@endsection
