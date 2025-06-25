@extends('dashboard.layout')

@section('title', __('dashboard.edit_borrow'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.edit_borrow')</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.borrows.update', $borrow->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <!-- User -->
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label">@lang('dashboard.borrow_user')</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $borrow->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Book -->
                    <div class="col-md-6 mb-3">
                        <label for="book_id" class="form-label">@lang('dashboard.borrow_book')</label>
                        <select class="form-select" id="book_id" name="book_id" required>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" {{ $borrow->book_id == $book->id ? 'selected' : '' }}>{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- Borrow Date -->
                    <div class="col-md-4 mb-3">
                        <label for="borrowed_at" class="form-label">@lang('dashboard.borrow_date')</label>
                        <input type="date" class="form-control" id="borrowed_at" name="borrowed_at" value="{{ $borrow->borrowed_at->format('Y-m-d') }}" required>
                    </div>

                    <!-- Due Date -->
                    <div class="col-md-4 mb-3">
                        <label for="due_date" class="form-label">@lang('dashboard.borrow_due_date')</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $borrow->due_date ? $borrow->due_date->format('Y-m-d') : '' }}" required>
                    </div>
                    
                    <!-- Return Date -->
                    <div class="col-md-4 mb-3">
                        <label for="returned_at" class="form-label">@lang('dashboard.borrow_return_date')</label>
                        <input type="date" class="form-control" id="returned_at" name="returned_at" value="{{ $borrow->returned_at ? $borrow->returned_at->format('Y-m-d') : '' }}">
                    </div>
                </div>

                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">@lang('dashboard.borrow_status')</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="borrowed" {{ $borrow->status == 'borrowed' ? 'selected' : '' }}>@lang('dashboard.borrowed')</option>
                        <option value="returned" {{ $borrow->status == 'returned' ? 'selected' : '' }}>@lang('dashboard.returned')</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">@lang('dashboard.save_changes')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
            </form>
        </div>
    </div>
</div>
@endsection 