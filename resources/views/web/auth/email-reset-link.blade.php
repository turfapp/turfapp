@extends('web.auth._layout')

@section('title')
    {{ __('Reset password') }}
@endsection

@section('form')
    <form id="email-reset-link" class="ta:form ta:form-fill-container" aria-live="assertive" accept-charset="UTF-8" method="post" action="{{ route('auth.password.email') }}">
        @csrf
        @if (session('status'))<p class="ta:form-text ta:form-text-success">{{ session('status') }}</p>@endif
        <div class="ta:form-group">
            <label for="account_email_field">{{ __('E-Mail Address') }}</label>
            <input id="account_email_field" type="email" name="email" autocomplete="off" autocapitalize="none" aria-required="true" required="required" aria-invalid="false" spellcheck="false" placeholder="{{ __('E-Mail Address') }}" autofocus="autofocus" />
            @error('email')<p class="ta:form-text ta:form-text-error">{{ $message }}</p>@enderror
        </div>
        <div class="ta:form-group">
            <input class="ta:button ta:button-primary" type="submit" value="{{ __('Send Password Reset Link') }}" />
        </div>
    </form>
@endsection
