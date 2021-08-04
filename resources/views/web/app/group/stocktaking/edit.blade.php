@extends('web.app.group._layout')

@section('app')
    <div class="card">
        <div class="header">
            <h1>{{ __('Edit inventory') }}</h1>
        </div>
        <div class="content">
            <form class="form" action="{{ Request::url() }}" method="POST">
                {{ csrf_field() }}

                <label for="num_items_bought">{{ __('Number of items bought') }}</label>
                <input id="num_items_bought" class="@error('num_items_bought') is-invalid @enderror" type="number" step="1" min="0" max="1000000" name="num_items_bought" value="" autofocus="autofocus" />
                <p class="input-explanation c-grey">{{ __('Leave empty to edit the stock without affecting the discrepancy.') }}</p>

                <label for="num_items_still_in_stock">{{ __('Number of items still in stock') }}</label>
                <input id="num_items_still_in_stock" class="@error('num_items_still_in_stock') is-invalid @enderror" type="number" step="1" max="10000000" name="num_items_still_in_stock" value="{{ $current_inventory }}" required="required" />
                <p class="input-explanation c-grey">{{ __('This is the number of items that were still in stock before adding new inventory. It should be the same as the number that is already filled in, but it may be lower if not every item was tallied.') }}</p>

                <button type="submit" class="submit">
                    {{ __('Save') }}
                </button>
            </form>
        </div>
    </div>
@endsection
