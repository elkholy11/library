@extends('layouts.auth')

@section('title', __('تسجيل الدخول'))

@section('content')
<div class="auth-card">
    <h2>@lang('تسجيل الدخول')</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="email">@lang('البريد الإلكتروني')</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}" autofocus>
            @error('email')<span class="error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="password">@lang('كلمة المرور')</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password')<span class="error">{{ $message }}</span>@enderror
        </div>
        <button type="submit" class="btn btn-primary">@lang('تسجيل الدخول')</button>
    </form>
    <a href="{{ route('register') }}" class="auth-link">@lang('ليس لديك حساب؟ سجل الآن')</a>
</div>
@endsection 