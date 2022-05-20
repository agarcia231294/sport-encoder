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

<script>
const setKG = id => {
    console.log("calculate stadistics");
    const btn = document.getElementById(id);
    let href = btn.getAttribute("href");
    const kg = btn.closest(".item-session").querySelector('.kg-input').value;
    if(kg){
        href.replace("-1",kg);
        btn.getAttribute("href",kg);
    }
}

</script>

@endsection