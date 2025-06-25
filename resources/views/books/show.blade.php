@extends('dashboard.layout')

@section('title', __('dashboard.book_details'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.book_details')</h1>
        <a href="{{ route('dashboard.books.index') }}" class="btn btn-secondary">@lang('dashboard.back')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 text-center">
                    <img src="{{ $book->cover_image ? asset('storage/' . $book->cover_image) : asset('images/default-book.png') }}" alt="{{ $book->title }}" class="img-fluid rounded" style="max-height: 400px;">
                </div>
                <div class="col-md-8">
                    <h3>{{ $book->title }}</h3>
                    <p class="text-muted">@lang('dashboard.by') <a href="#">{{ $book->author->name ?? 'N/A' }}</a> in <a href="#">{{ $book->category->name ?? 'N/A' }}</a></p>
                    
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>@lang('dashboard.book_isbn'):</strong> {{ $book->isbn ?? 'N/A' }}</li>
                        <li class="list-group-item"><strong>@lang('dashboard.book_published_at'):</strong> {{ $book->published_at ? $book->published_at->format('M d, Y') : 'N/A' }}</li>
                        <li class="list-group-item"><strong>@lang('dashboard.book_stock'):</strong> {{ $book->stock }}</li>
                        <li class="list-group-item">
                            <strong>@lang('dashboard.status'):</strong>
                            @if($book->is_active)
                                <span class="badge bg-success">@lang('dashboard.active')</span>
                            @else
                                <span class="badge bg-danger">@lang('dashboard.inactive')</span>
                            @endif
                        </li>
                    </ul>

                    <h5 class="mt-4">@lang('dashboard.book_description_en')</h5>
                    <p>{{ $book->description ?? 'No description provided.' }}</p>
                    
                    <div class="mt-4">
                        <a href="{{ route('dashboard.books.edit', $book->id) }}" class="btn btn-primary">@lang('dashboard.edit')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 