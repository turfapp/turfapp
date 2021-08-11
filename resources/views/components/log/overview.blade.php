<div class="activity-overview">
    @if($groups->count() > 0)
        @foreach($groups as $log_date => $log_items)
            <x-log::section :date="$log_date" :items="$log_items"></x-log::section>
        @endforeach
        @if($total > $shown)
            <p class="with-margin t-centered">{{ __('Showing only the last :num_shown of :num_total log items', ['num_shown' => $shown, 'num_total' => $total]) }}</p>
        @endif
    @else
        <p class="t-centered">{{ __('Nothing has happened yet.') }}</p>
    @endif
</div>
