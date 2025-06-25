@extends('dashboard.layout')

@section('title', __('dashboard.profile_details'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.profile_details')</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">{{ $user->name }}</h6>
            <a href="{{ route('dashboard.profile.edit') }}" class="btn btn-primary">@lang('dashboard.edit_profile')</a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ $user->profile_photo_url ?? 'https://via.placeholder.com/150' }}" alt="Profile Photo" class="img-fluid rounded-circle mb-3" style="width: 150px; height: 150px;">
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>
                </div>
                <div class="col-md-8">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>@lang('dashboard.phone'):</strong> {{ $user->profile->phone ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>@lang('dashboard.address'):</strong> {{ $user->profile->address ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>@lang('dashboard.bio'):</strong><p class="mt-2">{{ $user->profile->bio ?? 'N/A' }}</p></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.profile-item {
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
}
.profile-item:last-child {
    border-bottom: none;
}
.profile-item strong {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--text-secondary);
}
.profile-item span, .profile-item p {
    font-size: 1.1rem;
}
</style>
@endpush 