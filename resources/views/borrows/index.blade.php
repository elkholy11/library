@extends('dashboard.layout')

@section('title', __('dashboard.borrow_list'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.borrows')</h1>
        <a href="{{ route('dashboard.borrows.create') }}" class="btn btn-primary">@lang('dashboard.add_borrow')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>@lang('dashboard.borrow_user')</th>
                            <th>@lang('dashboard.borrow_book')</th>
                            <th>@lang('dashboard.borrow_date')</th>
                            <th>@lang('dashboard.borrow_due_date')</th>
                            <th>@lang('dashboard.borrow_return_date')</th>
                            <th>@lang('dashboard.borrow_status')</th>
                            <th>@lang('dashboard.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrows as $borrow)
                            <tr>
                                <td>{{ $borrow->user->name ?? 'N/A' }}</td>
                                <td>{{ $borrow->book->title ?? 'N/A' }}</td>
                                <td>{{ $borrow->borrowed_at->format('Y-m-d') }}</td>
                                <td>{{ $borrow->due_date ? $borrow->due_date->format('Y-m-d') : 'N/A' }}</td>
                                <td>{{ $borrow->returned_at ? $borrow->returned_at->format('Y-m-d') : 'N/A' }}</td>
                                <td>
                                    @if($borrow->status == 'returned')
                                        <span class="badge bg-success">@lang('dashboard.returned')</span>
                                    @elseif($borrow->due_date && $borrow->due_date->isPast())
                                        <span class="badge bg-danger">@lang('dashboard.overdue')</span>
                                    @else
                                        <span class="badge bg-warning text-dark">@lang('dashboard.borrowed')</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('dashboard.borrows.show', $borrow->id) }}" class="btn btn-info btn-sm" title="@lang('dashboard.show')"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('dashboard.borrows.edit', $borrow->id) }}" class="btn btn-primary btn-sm" title="@lang('dashboard.edit')"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('dashboard.borrows.destroy', $borrow->id) }}" method="POST" onsubmit="return confirm('@lang('dashboard.confirm_delete')');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No borrows found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($borrows->hasPages())
                <div class="mt-4">
                    {{ $borrows->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 