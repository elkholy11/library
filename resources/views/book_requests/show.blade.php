@extends('dashboard.layout')

@section('title', __('dashboard.book_request_details'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.book_request_details')</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>@lang('dashboard.book_request_user'):</strong> {{ $bookRequest->user->name ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>@lang('dashboard.book_request_title'):</strong> {{ $bookRequest->book_title }}</li>
                <li class="list-group-item"><strong>@lang('dashboard.book_request_author'):</strong> {{ $bookRequest->author_name ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>@lang('dashboard.note'):</strong> {{ $bookRequest->note ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>@lang('dashboard.book_request_date'):</strong> {{ $bookRequest->created_at->format('M d, Y') }}</li>
                <li class="list-group-item">
                    <strong>@lang('dashboard.book_request_status'):</strong>
                    @if($bookRequest->status == 'approved')
                        <span class="badge bg-success">@lang('dashboard.approved')</span>
                    @elseif($bookRequest->status == 'rejected')
                        <span class="badge bg-danger">@lang('dashboard.rejected')</span>
                    @else
                        <span class="badge bg-warning text-dark">@lang('dashboard.pending')</span>
                    @endif
                </li>
            </ul>
            <div class="mt-4">
                <a href="{{ route('dashboard.book_requests.edit', $bookRequest->id) }}" class="btn btn-primary">@lang('dashboard.edit')</a>
            </div>
        </div>
    </div>
</div>
@endsection 