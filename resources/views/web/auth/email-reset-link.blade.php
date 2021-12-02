@extends('web.auth._layout')

@section('title')
    {{ __('Reset password') }}
@endsection

@section('form')
    <form id="email-reset-link" class="ta:form" aria-live="assertive" accept-charset="UTF-8" method="post" action="{{ route('auth.password.email') }}">
        @csrf
        @if (session('status'))
            <p class="ta:form-text ta:form-text-success">{{ session('status') }}</p><br/>
        @else
            <div class="ta:form-group">
                <label for="account_email_field">{{ __('E-Mail Address') }}</label>
                <input id="account_email_field" type="email" name="email" autocapitalize="none" aria-required="true" required="required" spellcheck="false" placeholder="{{ __('E-Mail Address') }}" autofocus="autofocus" />
                @error('email')<p class="ta:form-text ta:form-text-error">{{ $message }}</p>@enderror
            </div>
            <div class="ta:form-group">
                <input class="ta:button ta:button-primary" type="submit" value="{{ __('Send Password Reset Link') }}" />
            </div>
        @endif
        <p class="ta:form-text ta:form-text-normal">{{ __('Already have an account?') }} <a href="{{ route('auth.login') }}">{{ __('Log in') }}</a></p>
    </form>
@endsection
