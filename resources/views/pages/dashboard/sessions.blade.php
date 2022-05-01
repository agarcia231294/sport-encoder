@extends('layouts.base')

@section('style')
    <link href="/css/pages/dashboard.css" rel="stylesheet">
@endsection

@section('content')

<h1>@lang('Your sessions')</h1>

<main class="box">

    <div class="sessions-list">
        @foreach ($sessions as $session)
            @includeIf('pages.dashboard.item-session',['session'=>$session])
        @endforeach
    </div>

</main>

@endsection