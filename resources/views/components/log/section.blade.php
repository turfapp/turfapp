<section class="log">
    <h1>{{ strtoupper($log_date) }}</h1>
    <div class="entries">
        @foreach($log_items as $log)
            <div class="entry">
                <span class="icon {{ $log->icon_class }}"></span><!--
                    --><div class="message">
                    <p><span class="t-bold">{{ $log->created_at->format('H:i') }}</span> {{ __($log->message_key, (array)$log->turf_log_params) }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
