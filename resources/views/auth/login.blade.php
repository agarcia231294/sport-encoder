@extends('layouts.base')

@section('style')
<link href="/css/pages/auth.css" rel="stylesheet">
@endsection

@section('content')



<h1>@lang('Login')</h1>



<form action="{{ route('login.post') }}" method="POST" class="box">
    @csrf
    <div class="form-group">
        <label for="email_address" class="">@lang('Email')</label>
        <div class="">
            <input type="text" id="email_address" class="form-control" name="email" required autofocus>
            @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label for="password" class="">@lang('Password')</label>
        <div class="">
            <input type="password" id="password" class="form-control" name="password" required>
            @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
            @endif
        </div>
    </div>


    <button type="submit" class="btn">
        @lang('Login')
    </button>
</form>
@endsection
