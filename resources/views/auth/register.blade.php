@extends('layouts.auth')
@section('title', __('تسجيل حساب جديد'))
@section('content')
<div class="auth-card">
    <h2>@lang('تسجيل حساب جديد')</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name">@lang('الاسم')</label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
            @error('name')<span class="error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="email">@lang('البريد الإلكتروني')</label>
            <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
            @error('email')<span class="error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="password">@lang('كلمة المرور')</label>
            <input type="password" name="password" id="password" class="form-control" required>
            @error('password')<span class="error">{{ $message }}</span>@enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">@lang('تأكيد كلمة المرور')</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">@lang('تسجيل')</button>
    </form>
    <a href="{{ route('login') }}" class="auth-link">@lang('لديك حساب؟ سجل الدخول')</a>
</div>
@endsection 