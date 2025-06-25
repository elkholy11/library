@extends('dashboard.layout')

@section('title', __('dashboard.edit_user'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.edit_user')</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">@lang('dashboard.user_name')</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">@lang('dashboard.user_email')</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Password -->
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">@lang('dashboard.password') (@lang('dashboard.leave_blank'))</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <!-- Password Confirmation -->
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">@lang('dashboard.user_password_confirmation')</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>

                <div class="row">
                    <!-- Role -->
                    <div class="col-md-4 mb-3">
                        <label for="role" class="form-label">@lang('dashboard.user_role')</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="user" @selected(old('role', $user->role) == 'user')>@lang('dashboard.user')</option>
                            <option value="admin" @selected(old('role', $user->role) == 'admin')>@lang('dashboard.admin')</option>
                        </select>
                    </div>

                    <!-- Language -->
                    <div class="col-md-4 mb-3">
                        <label for="language" class="form-label">@lang('dashboard.language')</label>
                        <select class="form-select" id="language" name="language" required>
                            <option value="ar" @selected(old('language', $user->language) == 'ar')>العربية</option>
                            <option value="en" @selected(old('language', 'en') == 'en')>English</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                         <label for="is_active" class="form-label">@lang('dashboard.status')</label>
                        <select class="form-select" id="is_active" name="is_active" required>
                            <option value="1" @selected(old('is_active', $user->is_active))>@lang('dashboard.active')</option>
                            <option value="0" @selected(!old('is_active', $user->is_active))>@lang('dashboard.inactive')</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">@lang('dashboard.save_changes')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
            </form>
        </div>
    </div>
</div>
@endsection
