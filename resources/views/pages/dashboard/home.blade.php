@extends('layouts.base')

@section('style')
    <link href="/css/pages/dashboard.css" rel="stylesheet">
@endsection

@section('content')



<main class="box">

    @lang('Welcome to your dashboard')

    <div class="shortcuts">
    
        <a class="item" href="{{ route('dashboard.sessions') }}">
            @lang('Sessions')
        </a>
    
        <a class="item" href="{{ route('dashboard.apikey') }}">
            @lang('Get API Key')
        </a>
    
    </div>

</main>

@endsection