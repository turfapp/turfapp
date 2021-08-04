@extends('web.app.group._layout')

@section('app')
    <div class="card">
        <div class="header">
            <h1>{{ __('Group settings') }}</h1>
        </div>
        <div class="content">
            <form class="form" action="{{ Request::url() }}" method="POST">
                {{ csrf_field() }}

                <label for="price_per_tally">{{ __('Price per tally') }} (&euro;)</label>
                <input id="price_per_tally" class="@error('price_per_tally') is-invalid @enderror" type="number" step="0.01" min="0.01" max="100" name="price_per_tally" value="{{ $price_per_tally }}" required="required" />

                <button type="submit" class="submit">
                    {{ __('Save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
