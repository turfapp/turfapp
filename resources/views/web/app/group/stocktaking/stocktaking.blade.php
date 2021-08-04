@extends('web.app.group._layout')

@section('app')
    <div class="card">
        <div class="header">
            <h1>{{ __('Stocktaking') }}</h1>
        </div>
        <div class="content">
            <div class="t-centered">
                <p class="t-125">{{ __('Current inventory') }}:</p>
                <div class="t-250">
                    <span>{{ $current_inventory }}</span>
                    <span> {{ __('items') }}</span>
                </div>
            </div><br/>
            <div class="t-centered">
                <p class="t-125">{{ __('Discrepancy') }}:</p>
                <div class="t-250">
                    <span>@if (is_numeric($discrepancy)) {{ number_format($discrepancy, 2) }} @else {{ $discrepancy }} @endif</span>
                    <span> %</span>
                </div>
                <p id="discrepancy-info" class="c-grey">{{ __('The discrepancy gives an indication of how many items are correctly tallied. A higher number indicates that more items are tallied correctly.') }}</p>
            </div><br/>
            <div class="t-centered">
                <p class="t-125">{{ __('Lost money') }}:</p>
                <div class="t-250">
                    <span>&euro; </span>
                    <span>{{ number_format($lost_money, 2) }}</span>
                </div>
            </div>
            <br/>
            <div class="form">
                <a class="submit centered" href="{{ route('group.stocktaking.edit', [$group->group_name]) }}">{{ __('Edit inventory') }}</a>
            </div>
        </div>
    </div>
@endsection
