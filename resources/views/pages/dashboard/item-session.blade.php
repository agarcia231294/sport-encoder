<div class="item-session">
    <div class="data"><span class="label">@lang('ID'):</span> {{ $session->id }}</div>
    <div class="data"><span class="label">@lang('Created at'):</span> {{ $session->created_at->format('d-m-Y h:i:s') }}</div>
    <div class="data"><span class="label">@lang('Max. distance'):</span> {{ $session->max_distance }} cm</div>
    <div class="data"><span class="label">@lang('Avg. distance'):</span> {{ $session->average_distance }} cm</div>
    <div class="data"><span class="label">@lang('Max. Speed'):</span> {{ $session->max_speed }} m/s</div>
    <div class="data"><span class="label">@lang('Avg. Speed'):</span> {{ $session->average_speed }} m/s</div>
    <div class="data"><span class="label">@lang('Max. Power'):</span> {{ $session->max_power }} Watts</div>
    <div class="data"><span class="label">@lang('Avg. Power'):</span> {{ $session->average_power }} Watts</div>
    <div class="data">
        <span class="label">@lang('KG'):</span>
        <div>
            <input class="kg-input" type="number" value="{{ $session->kg }}">
            <button class="btn">@lang('Save')</button>
        </div>
    </div>
    <div class="actions">
        <button class="btn">@lang('Calculate statistics')</button>
        <button class="btn gray">@lang('See graph')</button>
        <button class="btn red">@lang('Delete')</button>
    </div>
</div>
