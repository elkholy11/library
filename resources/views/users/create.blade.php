@extends('dashboard.layout')

@section('title', __('dashboard.add_user'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.add_user')</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.users.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- Name -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">@lang('dashboard.user_name')</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">@lang('dashboard.user_email')</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Password -->
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">@lang('dashboard.user_password')</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <!-- Password Confirmation -->
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">@lang('dashboard.user_password_confirmation')</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <div class="row">
                    <!-- Role -->
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">@lang('dashboard.user_role')</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="user" selected>@lang('dashboard.user')</option>
                            <option value="admin">@lang('dashboard.admin')</option>
                        </select>
                    </div>

                    <!-- Language -->
                    <div class="col-md-6 mb-3">
                        <label for="language" class="form-label">@lang('dashboard.language')</label>
                        <select class="form-select" id="language" name="language" required>
                            <option value="ar" selected>العربية</option>
                            <option value="en">English</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- Status -->
                    <div class="col-md-6 mb-3 align-self-center">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">@lang('dashboard.active')</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">@lang('dashboard.save')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
            </form>
        </div>
    </div>
</div>
@endsection
