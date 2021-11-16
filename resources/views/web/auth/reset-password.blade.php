@extends('web.auth._layout')

@section('title')
    {{ __('Reset password') }}
@endsection

@section('form')
    <form id="reset-password" class="ta:form ta:form-fill-container" aria-live="assertive" accept-charset="UTF-8" method="post" action="{{ route('auth.password.reset') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <!-- TODO -->
        <div class="ta:form-group">
            <input class="ta:button ta:button-primary" type="submit" value="{{ __('Reset Password') }}" />
        </div>
    </form>
@endsection
