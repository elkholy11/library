@extends('dashboard.layout')

@section('title', $author->name)

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.author_details')</h1>
        <a href="{{ route('dashboard.authors.index') }}" class="btn btn-secondary">@lang('dashboard.back')</a>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- Author Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $author->name }}</h6>
                </div>
                <div class="card-body">
                    <p><strong>@lang('dashboard.author_name_en'):</strong> {{ $author->name }}</p>
                    @if($author->ar_name)
                        <p><strong>@lang('dashboard.author_name_ar'):</strong> {{ $author->ar_name }}</p>
                    @endif
                    <hr>
                    <strong>@lang('dashboard.author_bio'):</strong>
                    <p>{{ $author->bio ?? 'N/A' }}</p>
                    <hr>
                    <a href="{{ route('dashboard.authors.edit', $author->id) }}" class="btn btn-primary btn-block">@lang('dashboard.edit')</a>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <!-- Books by Author Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@lang('dashboard.books_by_author')</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>@lang('dashboard.book_title')</th>
                                    <th>@lang('dashboard.book_category')</th>
                                    <th>@lang('dashboard.status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($author->books as $book)
                                    <tr>
                                        <td>{{ $book->title }}</td>
                                        <td>{{ $book->category->name ?? 'N/A' }}</td>
                                        <td>
                                            @if($book->is_active)
                                                <span class="badge bg-success">@lang('dashboard.active')</span>
                                            @else
                                                <span class="badge bg-danger">@lang('dashboard.inactive')</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">@lang('dashboard.no_books_found')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 