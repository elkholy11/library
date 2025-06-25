@extends('dashboard.layout')

@section('title', __('dashboard.book_request_list'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.book_requests')</h1>
        <a href="{{ route('dashboard.book_requests.create') }}" class="btn btn-primary">@lang('dashboard.add_book_request')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>@lang('dashboard.book_request_user')</th>
                            <th>@lang('dashboard.book_request_title')</th>
                            <th>@lang('dashboard.book_request_author')</th>
                            <th>@lang('dashboard.book_request_status')</th>
                            <th>@lang('dashboard.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookRequests as $request)
                            <tr>
                                <td>{{ $request->user->name ?? 'N/A' }}</td>
                                <td>{{ $request->book_title }}</td>
                                <td>{{ $request->author_name ?? 'N/A' }}</td>
                                <td>
                                    @if($request->status == 'approved')
                                        <span class="badge bg-success">@lang('dashboard.approved')</span>
                                    @elseif($request->status == 'rejected')
                                        <span class="badge bg-danger">@lang('dashboard.rejected')</span>
                                    @else
                                        <span class="badge bg-warning text-dark">@lang('dashboard.pending')</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('dashboard.book_requests.show', $request->id) }}" class="btn btn-info btn-sm" title="@lang('dashboard.show')"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('dashboard.book_requests.edit', $request->id) }}" class="btn btn-primary btn-sm" title="@lang('dashboard.edit')"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('dashboard.book_requests.destroy', $request->id) }}" method="POST" onsubmit="return confirm('@lang('dashboard.confirm_delete')');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No book requests found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($bookRequests->hasPages())
                <div class="mt-4">
                    {{ $bookRequests->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 