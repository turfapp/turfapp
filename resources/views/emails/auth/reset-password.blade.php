<p>{{ __('You are receiving this email because you requested a password reset for your TurfApp account.') }}</p>
<p>{{ __('Please go to the following page and choose a new password:') }}</p>

<a href="{{ $url }}">{{ $url }}</a>

<p>{{ __('This password reset link will expire in :count minutes.', ['count' => $expires_in]) }}</p>
