@extends('dashboard.layout')

@section('title', __('dashboard.book_list'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.books')</h1>
        <a href="{{ route('dashboard.books.create') }}" class="btn btn-primary">@lang('dashboard.add_book')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>@lang('dashboard.book_image')</th>
                            <th>@lang('dashboard.book_title')</th>
                            <th>@lang('dashboard.book_author')</th>
                            <th>@lang('dashboard.book_category')</th>
                            <th>@lang('dashboard.book_stock')</th>
                            <th>@lang('dashboard.status')</th>
                            <th>@lang('dashboard.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                            <tr>
                                <td>
                                    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-book.png') }}" alt="{{ $book->title }}" style="width: 40px; height: 60px; object-fit: cover;">
                                </td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author->name ?? 'N/A' }}</td>
                                <td>{{ $book->category->name ?? 'N/A' }}</td>
                                <td>{{ $book->available_quantity }}</td>
                                <td>
                                    @if($book->is_active)
                                        <span class="badge bg-success">@lang('dashboard.active')</span>
                                    @else
                                        <span class="badge bg-danger">@lang('dashboard.inactive')</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('dashboard.books.show', $book->id) }}" class="btn btn-info btn-sm" title="@lang('dashboard.show')"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('dashboard.books.edit', $book->id) }}" class="btn btn-primary btn-sm" title="@lang('dashboard.edit')"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('dashboard.books.destroy', $book->id) }}" method="POST" onsubmit="return confirm('@lang('dashboard.confirm_delete')');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No books found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($books->hasPages())
                <div class="mt-4">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 