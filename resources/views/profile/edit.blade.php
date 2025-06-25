@extends('dashboard.layout')

@section('title', __('dashboard.edit_profile'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.edit_profile')</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-8">
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">@lang('dashboard.user_name')</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">@lang('dashboard.user_email')</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">@lang('dashboard.phone')</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->profile->phone ?? '') }}">
                        </div>
                        <!-- Address -->
                        <div class="mb-3">
                            <label for="address" class="form-label">@lang('dashboard.address')</label>
                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $user->profile->address ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <!-- Profile Photo -->
                        <img src="{{ $user->profile_photo_url ?? 'https://via.placeholder.com/150' }}" alt="Profile Photo" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                        <div class="mb-3">
                            <label for="profile_photo" class="form-label">@lang('dashboard.profile_photo')</label>
                            <input type="file" class="form-control" id="profile_photo" name="profile_photo">
                        </div>
                    </div>
                </div>

                <!-- Bio -->
                <div class="mb-3">
                    <label for="bio" class="form-label">@lang('dashboard.bio')</label>
                    <textarea class="form-control" id="bio" name="bio" rows="4">{{ old('bio', $user->profile->bio ?? '') }}</textarea>
                </div>
                <hr>
                <!-- Password -->
                <h5 class="mb-3">@lang('dashboard.change_password')</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">@lang('dashboard.new_password')</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">@lang('dashboard.confirm_password')</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">@lang('dashboard.save_changes')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
            </form>
        </div>
    </div>
</div>
@endsection 