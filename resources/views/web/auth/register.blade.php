@extends('web.auth._layout')

@section('app')
    <div class="center-box-container">
        <div class="logo-container">
            <span class="logo"><a href="{{ route('index') }}">{{ config('app.name') }}</a></span>
        </div>
        <div class="center-box">
            <h1>{{ __('Register') }}</h1>
            <div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus />

                        @error('name')
                        <span class="invalid-form-input-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

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
                        <input id="password" type="password" class="form-input @error('password') is-invalid @enderror" name="password" required />

                        @error('password')
                        <span class="invalid-form-input-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-confirm">{{ __('Confirm Password') }}</label>
                        <input id="password-confirm" type="password" class="form-input" name="password_confirmation" required />
                    </div>

                    <div class="form-group">
                        <button type="submit" class="button button-blue">
                            {{ __('Register') }}
                        </button>
                    </div>
                </form>

                <div class="alternatives">
                    <a href="{{ route('login') }}">{{ __('Click here if you already have an account') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
