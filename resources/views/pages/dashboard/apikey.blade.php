@extends('layouts.base')

@section('style')
    <link href="/css/pages/dashboard.css" rel="stylesheet">
@endsection

@section('content')


<div class="box apikey">
    @lang('Your API KEY is:')
    <input class="apikey-input" type="text" disabled value="{{Auth::user()->api_key}}">

    <div>
        <a class="btn" href="{{ route('dashboard.apikey.regenerate') }}">@lang('Regenerate API Key')</a>
    </div>
</div>

@endsection