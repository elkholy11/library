@extends('dashboard.layout')

@section('title', __('dashboard.add_book'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.add_book')</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.books.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('books._form')
            </form>
        </div>
    </div>
</div>
@endsection
