@extends('dashboard.layout')

@section('title', __('dashboard.edit_book_request'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.edit_book_request')</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.book_requests.update', $bookRequest->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- User -->
                <div class="mb-3">
                    <label for="user_id" class="form-label">@lang('dashboard.user')</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id', $bookRequest->user_id) == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Book Title -->
                <div class="mb-3">
                    <label for="book_title" class="form-label">@lang('dashboard.book_request_title')</label>
                    <input type="text" class="form-control" id="book_title" name="book_title" value="{{ old('book_title', $bookRequest->book_title) }}" required>
                </div>

                <!-- Author Name -->
                <div class="mb-3">
                    <label for="author_name" class="form-label">@lang('dashboard.book_request_author')</label>
                    <input type="text" class="form-control" id="author_name" name="author_name" value="{{ old('author_name', $bookRequest->author_name) }}">
                </div>

                <!-- Note -->
                <div class="mb-3">
                    <label for="note" class="form-label">@lang('dashboard.note')</label>
                    <textarea class="form-control" id="note" name="note" rows="4">{{ old('note', $bookRequest->note) }}</textarea>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">@lang('dashboard.book_request_status')</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="pending" {{ $bookRequest->status == 'pending' ? 'selected' : '' }}>@lang('dashboard.pending')</option>
                        <option value="approved" {{ $bookRequest->status == 'approved' ? 'selected' : '' }}>@lang('dashboard.approved')</option>
                        <option value="rejected" {{ $bookRequest->status == 'rejected' ? 'selected' : '' }}>@lang('dashboard.rejected')</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">@lang('dashboard.save_changes')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
            </form>
        </div>
    </div>
</div>
@endsection
