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
const setKG = e => {
    console.log("calculate stadistics");

    let href = this.getAttribute("href");
    const kg = this.closest("item-session").querySelector('kg-input').value();
    if(kg){
        href.replace("-1",kg);
        this.getAttribute("href",kg);
    }
}

</script>

@endsection