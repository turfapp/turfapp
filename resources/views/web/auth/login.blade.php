@extends('web.auth._layout')

@section('app')
<div class="center-box-container">
    <div class="logo-container">
        <span class="logo"><a href="{{ route('index') }}">{{ config('app.name') }}</a></span>
    </div>
    <div class="center-box">
        <h1>{{ __('Login') }}</h1>
        <div>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">{{ __('E-Mail Address') }}</label>
                    <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />

                    @error('email')
                    <span class="invalid-form-input-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <input id="password" type="password" class="form-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" />

                    @error('password')
                    <span class="invalid-form-input-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <input type="hidden" name="remember" value="on" />

                <div class="form-group">
                    <button type="submit" class="button button-blue">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>

            <div class="alternatives">
                <a href="{{ route('register') }}">{{ __('Register') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
