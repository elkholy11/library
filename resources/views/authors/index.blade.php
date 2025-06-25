@extends('dashboard.layout')

@section('title', __('dashboard.author_list'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.authors')</h1>
        <a href="{{ route('dashboard.authors.create') }}" class="btn btn-primary">@lang('dashboard.add_author')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>@lang('dashboard.author_name')</th>
                            <th>@lang('dashboard.books_count')</th>
                            <th>@lang('dashboard.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($authors as $author)
                            <tr>
                                <td>{{ $author->name }}</td>
                                <td>{{ $author->books_count ?? 0 }}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('dashboard.authors.show', $author->id) }}" class="btn btn-info btn-sm" title="@lang('dashboard.show')"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('dashboard.authors.edit', $author->id) }}" class="btn btn-primary btn-sm" title="@lang('dashboard.edit')"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('dashboard.authors.destroy', $author->id) }}" method="POST" onsubmit="return confirm('@lang('dashboard.confirm_delete')');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No authors found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($authors->hasPages())
                <div class="mt-4">
                    {{ $authors->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 