@extends('dashboard.layout')

@section('title', __('dashboard.add_category'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.add_category')</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.categories.store') }}" method="POST">
                @csrf
                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">@lang('dashboard.category_name')</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <button type="submit" class="btn btn-primary">@lang('dashboard.save')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
            </form>
        </div>
    </div>
</div>
@endsection 