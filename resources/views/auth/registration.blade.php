@extends('layouts.base')

@section('style')
<link href="/css/pages/auth.css" rel="stylesheet">
@endsection

@section('content')


<h1>@lang('Register')</h1>


<form class="box" action="{{ route('register.post') }}" method="POST">

    @csrf
    <div class="form-group">
        <label for="name" class="">@lang('Name')</label>
        <div class="">
            <input type="text" id="name" class="" name="name" required autofocus>
            @if ($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="email_address" class="">@lang('Email')</label>
        <div class="">
            <input type="text" id="email_address" class="" name="email" required autofocus>
            @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="password" class="">@lang('Password')</label>
        <div class="">
            <input type="password" id="password" class="" name="password" required>
            @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        </div>
    </div>

    <button type="submit" class="btn">
        @lang('Register')
    </button>
</form>


<div class="box">
    <p>@lang('Already have an account?')</p>
    <a class="btn" href="{{ route('login') }}">@lang('Login')</a>
</div>
@endsection
