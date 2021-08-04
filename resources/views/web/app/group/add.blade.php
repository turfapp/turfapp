@extends('web.app.group._layout')

@section('app')
    <div class="card">
        <div class="header">
            <h1>{{ __('Invite people to group') }}</h1>
        </div>
        <div class="content">
            <div class="form">
                <label for="join-link"></label>
                <input id="join-link" type="text" readonly="readonly" value="{{ route('group.join', [$group->group_name, $group_join_code]) }}" />
            </div>

            <p class="with-margin">{{ __('Everyone that uses TurfApp can use this link to join this group. Only share this link with people you trust.') }}</p>

            <div id="join-link-buttons">
                <a class="join-link-button" href="whatsapp://send?text={{ urlencode(__('Follow this link to join my TurfApp group: :link', ['link' => route('group.join', [$group->group_name, $group_join_code] )])) }}" data-action="share/whatsapp/share">
                    <span class="fas fa-share"></span>
                    <button id="share-link-button">{{ __('Send link via WhatsApp') }}</button>
                </a>
                <a id="copy-link" class="join-link-button" data-copied="{{ __('Link copied!') }}" data-copyfailed="{{ __('Copying failed') }}">
                    <span class="fas fa-copy"></span>
                    <button id="copy-link-button">{{ __('Copy link') }}</button>
                </a>
                @if ($logged_user_membership->member_is_admin)
                    <a class="join-link-button" data-form="#reset-link-form" data-confirm="{{ __('Are you sure you want to reset the join link for this group? Doing so will cause the existing join link to no longer work.') }}" href="{{ route('group.add.reset', [$group->group_name]) }}">
                        <span class="fas fa-ban"></span>
                        <button id="reset-link-button">{{ __('Reset link') }}</button>
                    </a>
                    <form id="reset-link-form" action="{{ route('group.add.reset', [$group->group_name]) }}" method="POST">
                        {{ csrf_field() }}
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
