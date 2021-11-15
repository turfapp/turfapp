@extends('web.auth._layout')

@section('title')
{{ __('Login') }}
@endsection

@section('form')
    <form id="login" class="ta:form" aria-live="assertive" accept-charset="UTF-8" method="post" action="{{ route('auth.login') }}">
        @csrf
        <div class="ta:form-group">
            <label for="account_email_field">{{ __('E-Mail Address') }}</label>
            <input id="account_email_field" type="text" name="email" autocomplete="off" autocapitalize="none" aria-required="true" required="required" aria-invalid="false" spellcheck="false" placeholder="{{ __('E-Mail Address') }}" autofocus="autofocus" />
            @error('email')<p class="ta:form-text ta:form-text-error">{{ $message }}</p>@enderror
        </div>
        <div class="ta:form-group">
            <label for="password_field">{{ __('Password') }}</label>
            <input id="password_field" type="password" name="password" aria-required="true" required="required" autocomplete="off" placeholder="{{ __('Password') }}" aria-invalid="false" />
            @error('password')<p class="ta:form-text ta:form-text-error">{{ $message }}</p>@enderror
        </div>
        <div class="ta:form-group">
            <input id="remember_me" type="checkbox" name="remember" value="yes" />
            <label for="remember_me">{{ __('Remember me') }}</label>
        </div>
        <div class="ta:form-group">
            <input class="ta:button ta:button-primary" type="submit" value="{{ __('Login') }}" />
        </div>
        <p class="ta:form-text ta:form-text-normal">{{ __('Don\'t have an account yet?') }} <a href="{{ route('auth.register') }}">{{ __('Register now') }}</a></p>
    </form>
@endsection

