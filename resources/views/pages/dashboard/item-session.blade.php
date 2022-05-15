<div class="item-session">
    <div class="data"><span class="label">@lang('ID'):</span> {{ $session->id }}</div>
    <div class="data"><span class="label">@lang('Created at'):</span> {{ $session->created_at->format('d-m-Y h:i:s') }}</div>
    <div class="data"><span class="label">@lang('Max. distance'):</span> {{ $session->max_distance }} cm</div>
    <div class="data"><span class="label">@lang('Avg. distance'):</span> {{ $session->average_distance }} cm</div>
    <div class="data"><span class="label">@lang('Max. Speed'):</span> {{ $session->max_speed }} m/s</div>
    <div class="data"><span class="label">@lang('Avg. Speed'):</span> {{ $session->average_speed }} m/s</div>
    <div class="actions">
        @if(is_null($session->max_distance) OR is_null($session->average_distance) OR is_null($session->max_speed) OR is_null($session->average_speed))
        <a class="btn" href="{{ route('dashboard.session.generateStadistics', ['id'=>$session->id]) }}">@lang('Calculate statistics')</a>
        @else
        <a class="btn gray" href="{{ route('dashboard.session.graph', ['id'=>$session->id]) }}">@lang('See graph')</a>
        @endif
        <a class="btn red" href="{{ route('dashboard.session.delete', ['id'=>$session->id]) }}" onclick="return confirm(`{{ __('Are you sure?') }}`)">@lang('Delete')</a>
    </div>
</div>
