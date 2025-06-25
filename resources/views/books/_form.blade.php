{{--
This is a shared form for creating and editing books.
It expects the following variables:
- $authors: A collection of authors for the dropdown.
- $categories: A collection of categories for the dropdown.
- $book (optional): The book model, used when editing.
--}}

<!-- Title -->
<div class="mb-3">
    <label for="title" class="form-label">@lang('dashboard.book_title_ar')</label>
    <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $book->title ?? '') }}" required>
</div>

<!-- English Title -->
<div class="mb-3">
    <label for="title_en" class="form-label">@lang('dashboard.book_title_en')</label>
    <input type="text" class="form-control" id="title_en" name="title_en" value="{{ old('title_en', $book->title_en ?? '') }}">
</div>

<!-- Description -->
<div class="mb-3">
    <label for="description" class="form-label">@lang('dashboard.book_description_ar')</label>
    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $book->description ?? '') }}</textarea>
</div>

<!-- English Description -->
<div class="mb-3">
    <label for="description_en" class="form-label">@lang('dashboard.book_description_en')</label>
    <textarea class="form-control" id="description_en" name="description_en" rows="3">{{ old('description_en', $book->description_en ?? '') }}</textarea>
</div>

<div class="row">
    <!-- ISBN -->
    <div class="col-md-6 mb-3">
        <label for="isbn" class="form-label">@lang('dashboard.book_isbn')</label>
        <input type="text" class="form-control" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn ?? '') }}">
    </div>

    <!-- Publisher -->
    <div class="col-md-6 mb-3">
        <label for="publisher" class="form-label">@lang('dashboard.book_publisher')</label>
        <input type="text" class="form-control" id="publisher" name="publisher" value="{{ old('publisher', $book->publisher ?? '') }}">
    </div>
</div>

<div class="row">
    <!-- Publication Date -->
    <div class="col-md-6 mb-3">
        <label for="publication_date" class="form-label">@lang('dashboard.book_published_at')</label>
        <input type="date" class="form-control" id="publication_date" name="publication_date" value="{{ old('publication_date', isset($book) ? \Carbon\Carbon::parse($book->publication_date)->format('Y-m-d') : '') }}">
    </div>

    <!-- Pages -->
    <div class="col-md-6 mb-3">
        <label for="pages" class="form-label">@lang('dashboard.book_pages')</label>
        <input type="number" class="form-control" id="pages" name="pages" value="{{ old('pages', $book->pages ?? '') }}" min="1">
    </div>
</div>

<div class="row">
    <!-- Language -->
    <div class="col-md-6 mb-3">
        <label for="language" class="form-label">@lang('dashboard.language')</label>
        <select class="form-select" id="language" name="language" required>
            <option value="ar" @selected(old('language', $book->language ?? '') == 'ar')>العربية</option>
            <option value="en" @selected(old('language', $book->language ?? '') == 'en')>English</option>
        </select>
    </div>

    <!-- Quantity -->
    <div class="col-md-6 mb-3">
        <label for="quantity" class="form-label">@lang('dashboard.quantity')</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $book->quantity ?? '') }}" required min="1">
    </div>
</div>

<div class="row">
    <!-- Category -->
    <div class="col-md-6 mb-3">
        <label for="category_id" class="form-label">@lang('dashboard.book_category')</label>
        <select class="form-select" id="category_id" name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $book->category_id ?? '') == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Author -->
    <div class="col-md-6 mb-3">
        <label for="author_id" class="form-label">@lang('dashboard.book_author')</label>
        <select class="form-select" id="author_id" name="author_id" required>
             @foreach($authors as $author)
                <option value="{{ $author->id }}" @selected(old('author_id', $book->author_id ?? '') == $author->id)>{{ $author->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<!-- Cover Image -->
<div class="mb-3">
    <label for="cover_image" class="form-label">@lang('dashboard.book_image')</label>
    <input class="form-control" type="file" id="cover_image" name="cover_image">
    @if (isset($book) && $book->cover_image)
        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="Cover Image" class="img-thumbnail mt-2" width="150">
    @endif
</div>

<button type="submit" class="btn btn-primary">@lang(isset($book) ? 'dashboard.save_changes' : 'dashboard.save')</button>
<a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>