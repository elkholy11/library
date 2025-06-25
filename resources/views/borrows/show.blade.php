@extends('dashboard.layout')

@section('title', __('dashboard.borrow_details'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.borrow_details')</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>@lang('dashboard.borrow_user'):</strong> {{ $borrow->user->name ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>@lang('dashboard.borrow_book'):</strong> {{ $borrow->book->title ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>@lang('dashboard.borrow_date'):</strong> {{ $borrow->borrowed_at->format('M d, Y') }}</li>
                <li class="list-group-item"><strong>@lang('dashboard.borrow_due_date'):</strong> {{ $borrow->due_date ? $borrow->due_date->format('M d, Y') : 'N/A' }}</li>
                <li class="list-group-item"><strong>@lang('dashboard.borrow_return_date'):</strong> {{ $borrow->returned_at ? $borrow->returned_at->format('M d, Y') : 'N/A' }}</li>
                <li class="list-group-item">
                    <strong>@lang('dashboard.borrow_status'):</strong>
                    @if($borrow->status == 'returned')
                        <span class="badge bg-success">@lang('dashboard.returned')</span>
                    @elseif($borrow->due_date && $borrow->due_date->isPast())
                        <span class="badge bg-danger">@lang('dashboard.overdue')</span>
                    @else
                        <span class="badge bg-warning text-dark">@lang('dashboard.borrowed')</span>
                    @endif
                </li>
            </ul>
            <div class="mt-4">
                <a href="{{ route('dashboard.borrows.edit', $borrow->id) }}" class="btn btn-primary">@lang('dashboard.edit')</a>
            </div>
        </div>
    </div>
</div>
@endsection 