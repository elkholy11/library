@extends('dashboard.layout')

@section('title', __('dashboard.add_author'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.add_author')</h1>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.authors.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">@lang('dashboard.author_name_en')</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="ar_name" class="form-label">@lang('dashboard.author_name_ar')</label>
                        <input type="text" class="form-control @error('ar_name') is-invalid @enderror" id="ar_name" name="ar_name" value="{{ old('ar_name') }}">
                        @error('ar_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">@lang('dashboard.author_bio')</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4">{{ old('bio') }}</textarea>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="status" class="form-label">@lang('dashboard.status')</label>
                    <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="active" @if(old('status') == 'active') selected @endif>@lang('dashboard.active')</option>
                        <option value="inactive" @if(old('status') == 'inactive') selected @endif>@lang('dashboard.inactive')</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">@lang('dashboard.save')</button>
                <a href="{{ route('dashboard.authors.index') }}" class="btn btn-secondary">@lang('dashboard.cancel')</a>
            </form>
        </div>
    </div>
</div>
@endsection 