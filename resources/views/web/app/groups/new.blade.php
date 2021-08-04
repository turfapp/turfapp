@extends('web.app._layout')

@section('app')
    <div class="card">
        <div class="header">
            <h1>{{ __('Create new group') }}</h1>
        </div>
        <div class="content">
            <form id="new-group-form" method="POST" action="{{ Request::url() }}" class="form">
                @csrf
                @method('POST')

                <label for="group_display_name">{{ __('Name') }}</label>
                <input id="group_display_name" class="@error('group_display_name') is-invalid @enderror" type="text" name="group_display_name" placeholder="{{ __('My awesome group') }}" maxlength="64" required="required" autofocus="autofocus" autocomplete="on" />

                <button type="submit" class="submit">
                    {{ __('Create group') }}
                </button>
            </form>
        </div>
    </div>
@endsection
