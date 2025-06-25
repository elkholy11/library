@extends('dashboard.layout')

@section('title', __('dashboard.category_details'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.category_details')</h1>
        <a href="{{ route('dashboard.categories.index') }}" class="btn btn-secondary">@lang('dashboard.back')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <h3>{{ $category->name }}</h3>
            <hr>

            <h5 class="mt-4">@lang('dashboard.books_in_category')</h5>
            @if($category->books->count() > 0)
                <ul class="list-group">
                    @foreach($category->books as $book)
                        <li class="list-group-item">
                            <a href="{{ route('dashboard.books.show', $book->id) }}">{{ $book->title }}</a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>@lang('dashboard.no_books_in_category')</p>
            @endif

            <div class="mt-4">
                <a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-primary">@lang('dashboard.edit')</a>
            </div>
        </div>
    </div>
</div>
@endsection 