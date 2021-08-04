@extends('web.auth._layout')

@section('app')
    <div class="center-box-container">
        <div class="logo-container">
            <span class="logo"><a href="{{ route('index') }}">{{ config('app.name') }}</a></span>
        </div>
        <div class="center-box">
            <h1>{{ __('Confirm Password') }}</h1>
            <div>
                {{ __('Please confirm your password before continuing.') }}

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="form-group">
                        <label for="password">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-input" name="password" required autocomplete="current-password" />

                        @error('password')
                        <span class="invalid-form-input-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="button button-blue">
                            {{ __('Confirm Password') }}
                        </button>
                    </div>
                </form>

                <div class="alternatives">
                    <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
