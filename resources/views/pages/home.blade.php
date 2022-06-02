@extends('layouts.base')

@section('style')
    <link href="/css/pages/home.css" rel="stylesheet">
@endsection

@section('content')
    
<section class="inspyre">
</section>

<main class="box">
    <div class="titles">
        <h1>@lang('Sportino encoder APP')</h1>
        <h2>@lang('Welcome to the sports revolution')</h2>
    </div>
    <div class="content">
        <div class="column">
            <h3>@lang('What is the Sportino Encoder?')</h3>
            <p>@lang('Record your training sessions to monitor your condition and progress. Get the data you need.')</p>
            <a href="{{ route('order') }}" class="btn">@lang('Order now')</a>
        </div>
        <div class="column">
            <h3>@lang('Already have your Sportino Encoder?')</h3>
            <p>@lang('Sign up for free to sync your data to the cloud. You can manage your workouts from your dashboard.')</p>
            <a href="{{ route('register') }}" class="btn">@lang('Sign up')</a>
        </div>
    </div>

</main>

@endsection