<div data-user="{{ $membership->user->id }}" class="row">
    <div class="name">
        <a href="{{ route('group.member', [$membership->group->group_name, $membership->user->id]) }}">
            @if($bold)
                <b>{{ $membership->user->name }}</b>
            @else
                {{ $membership->user->name }}
            @endif
        </a>
    </div>
    <div class="controls">
        <div class="decrement"><i class="fas fa-minus"></i></div>
        <div class="amount" data-amount="{{ $membership->turf_amount }}">{{ $membership->turf_amount }}</div>
        <div class="increment"><i class="fas fa-plus"></i></div>
    </div>
</div>
