@extends('web.auth._layout')

@section('title')
    {{ __('Register') }}
@endsection

@section('form')
    <form id="register" class="ta:form ta:form-fill-container" aria-live="assertive" accept-charset="UTF-8" method="post" action="{{ route('auth.register') }}">
        @csrf
        <div class="ta:form-group">
            <label for="account_name_field">{{ __('Name') }}</label>
            <input id="account_name_field" type="text" name="name" autocomplete="off" autocapitalize="none" aria-required="true" required="required" aria-invalid="false" spellcheck="false" placeholder="{{ __('Name') }}" autofocus="autofocus" />
            @error('name')<p class="ta:form-text ta:form-text-error">{{ $message }}</p>@enderror
        </div>
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
            <label for="password_confirm_field">{{ __('Confirm Password') }}</label>
            <input id="password_confirm_field" type="password" name="password_confirmation" aria-required="true" required="required" autocomplete="off" placeholder="{{ __('Confirm Password') }}" aria-invalid="false" />
            @error('password_confirmation')<p class="ta:form-text ta:form-text-error">{{ $message }}</p>@enderror
        </div>
        <div class="ta:form-group">
            <input id="agree_to_privacy_policy" type="checkbox" name="agree_to_privacy_policy" value="yes" aria-required="true" required="required" />
            <label for="agree_to_privacy_policy">{!! __('I agree to TurfApp\'s <a href=":privacy_policy">privacy policy</a>.', ['privacy_policy' => route('privacy')]) !!}</label>
        </div>
        <div class="ta:form-group">
            <input class="ta:button ta:button-primary" type="submit" value="{{ __('Register') }}" />
        </div>
        <p class="ta:form-text ta:form-text-normal">{{ __('Already have an account?') }} <a href="{{ route('auth.login') }}">{{ __('Log in') }}</a></p>
    </form>
@endsection
