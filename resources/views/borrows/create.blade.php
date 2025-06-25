@extends('dashboard.layout')

@section('title', __('dashboard.add_borrow'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.add_borrow')</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.borrows.store') }}" method="POST">
                @csrf
                <div class="row">
                    <!-- User -->
                    <div class="col-md-6 mb-3">
                        <label for="user_id" class="form-label">@lang('dashboard.borrow_user')</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="">Select User</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Book -->
                    <div class="col-md-6 mb-3">
                        <label for="book_id" class="form-label">@lang('dashboard.borrow_book')</label>
                        <select class="form-select" id="book_id" name="book_id" required>
                            <option value="">Select Book</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}">{{ $book->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- Borrow Date -->
                    <div class="col-md-6 mb-3">
                        <label for="borrowed_at" class="form-label">@lang('dashboard.borrow_date')</label>
                        <input type="date" class="form-control" id="borrowed_at" name="borrowed_at" value="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- Due Date -->
                    <div class="col-md-6 mb-3">
                        <label for="due_date" class="form-label">@lang('dashboard.borrow_due_date')</label>
                        <input type="date" class="form-control" id="due_date" name="due_date" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">@lang('dashboard.save')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
            </form>
        </div>
    </div>
</div>
@endsection 