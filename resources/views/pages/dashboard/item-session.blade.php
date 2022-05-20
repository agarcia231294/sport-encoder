<div class="item-session">
    <div class="data"><span class="label">@lang('ID'):</span> {{ $session->id }}</div>
    <div class="data"><span class="label">@lang('Created at'):</span> {{ $session->created_at->format('d-m-Y h:i:s') }}</div>
    <div class="data"><span class="label">@lang('Max. distance'):</span> {{ $session->max_distance }} cm</div>
    <div class="data"><span class="label">@lang('Avg. distance'):</span> {{ $session->average_distance }} cm</div>
    <div class="data"><span class="label">@lang('Max. Speed'):</span> {{ $session->max_speed }} m/s</div>
    <div class="data"><span class="label">@lang('Avg. Speed'):</span> {{ $session->average_speed }} m/s</div>
    <div class="data"><span class="label">@lang('Max. Acceleration'):</span> {{ $session->max_acceleration }} m/s²</div>
    <div class="data"><span class="label">@lang('Avg. Acceleration'):</span> {{ $session->avg_acceleration }} m/s²</div>
    <div class="data"><span class="label">@lang('Max. Force'):</span> {{ $session->max_force }} N</div>
    <div class="data"><span class="label">@lang('Avg. Force'):</span> {{ $session->avg_force }} N</div>
    <div class="data"><span class="label">@lang('Max. Power'):</span> {{ $session->max_power }} W</div>
    <div class="data"><span class="label">@lang('Avg. Power'):</span> {{ $session->avg_power }} W</div>
    <div class="data"><span class="label">@lang('Kg'):</span> <input type="number" step="any" class="kg-input" value="{{$session->kg}}"> KG</div>
    <div class="actions">
        <a class="btn" id="calculate{{$session->id}}" href="{{ route('dashboard.session.generateStadistics', ['id'=>$session->id, 'kg'=> -1]) }}" onclick="setKG('calculate{{$session->id}}')">@lang('Calculate statistics')</a>
        @if(!(is_null($session->max_distance) OR is_null($session->average_distance) OR is_null($session->max_speed) OR is_null($session->average_speed)))
        <a class="btn gray" href="{{ route('dashboard.session.graph', ['id'=>$session->id]) }}">@lang('See graph')</a>
        @endif
        <a class="btn red" href="{{ route('dashboard.session.delete', ['id'=>$session->id]) }}" onclick="return confirm(`{{ __('Are you sure?') }}`)">@lang('Delete')</a>
    </div>
</div>

