@extends('web.auth._layout')

@section('title')
    {{ __('Reset password') }}
@endsection

@section('form')
    <form id="reset-password" class="ta:form" aria-live="assertive" accept-charset="UTF-8" method="post" action="{{ route('auth.password.reset') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}" />
        <input type="hidden" name="email" value="{{ $email }}" />
        <div class="ta:form-group">
            <label for="password_field">{{ __('Password') }}</label>
            <input id="password_field" type="password" name="password" aria-required="true" required="required" autocomplete="off" placeholder="{{ __('Password') }}" autofocus="autofocus" />
            @error('password')<p class="ta:form-text ta:form-text-error">{{ $message }}</p>@enderror
        </div>
        <div class="ta:form-group">
            <label for="password_confirm_field">{{ __('Confirm Password') }}</label>
            <input id="password_confirm_field" type="password" name="password_confirmation" aria-required="true" required="required" autocomplete="off" placeholder="{{ __('Confirm Password') }}" />
            @error('password_confirmation')<p class="ta:form-text ta:form-text-error">{{ $message }}</p>@enderror
        </div>
        <div class="ta:form-group">
            <input class="ta:button ta:button-primary" type="submit" value="{{ __('Reset Password') }}" />
        </div>
    </form>
@endsection
