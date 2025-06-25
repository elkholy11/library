@extends('dashboard.layout')

@section('title', __('dashboard.user_details'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ $user->name }}</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">@lang('dashboard.user_details')</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <p><strong>@lang('dashboard.user_name'):</strong> {{ $user->name }}</p>
                    <p><strong>@lang('dashboard.user_email'):</strong> {{ $user->email }}</p>
                    <p><strong>@lang('dashboard.role'):</strong> <span class="badge bg-{{ $user->role === 'admin' ? 'success' : 'info' }}">{{ $user->role }}</span></p>
                    <p><strong>@lang('dashboard.status'):</strong> <span class="badge bg-{{ $user->is_active ? 'success' : 'danger' }}">{{ $user->is_active ? __('dashboard.active') : __('dashboard.inactive') }}</span></p>
                    <hr>
                    <h5>@lang('dashboard.profile_details')</h5>
                    <p><strong>@lang('dashboard.phone'):</strong> {{ $user->profile->phone ?? '-' }}</p>
                    <p><strong>@lang('dashboard.address'):</strong> {{ $user->profile->address ?? '-' }}</p>
                    <p><strong>@lang('dashboard.bio'):</strong></p>
                    <p>{{ $user->profile->bio ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 