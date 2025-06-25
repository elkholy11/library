@extends('dashboard.layout')

@section('title', __('dashboard.add_order'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.add_order')</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('dashboard.orders.store') }}" method="POST">
                @csrf
                <!-- User -->
                <div class="mb-3">
                    <label for="user_id" class="form-label">@lang('dashboard.order_user')</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        <option value="">@lang('dashboard.select_user')</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <hr>

                <h4>@lang('dashboard.books')</h4>
                <div id="books-container">
                    <!-- Book Row (template) -->
                    <div class="row book-row mb-3 align-items-end">
                        <div class="col-md-7">
                            <label class="form-label">@lang('dashboard.book')</label>
                            <select name="books[0][id]" class="form-select book-select" required>
                                <option value="">@lang('dashboard.select_book')</option>
                                @foreach($books as $book)
                                    <option value="{{ $book->id }}" data-quantity="{{ $book->available_quantity }}">{{ $book->title }} (@lang('dashboard.available'): {{ $book->available_quantity }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">@lang('dashboard.quantity')</label>
                            <input type="number" name="books[0][quantity]" class="form-control quantity-input" min="1" required>
                        </div>
                        <div class="col-md-2">
                             <button type="button" class="btn btn-danger remove-book-btn">@lang('dashboard.remove')</button>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-book-btn" class="btn btn-success mt-2">@lang('dashboard.add_another_book')</button>
                
                <hr>

                <button type="submit" class="btn btn-primary">@lang('dashboard.save')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let bookRowIndex = 1;
    const booksContainer = document.getElementById('books-container');
    const addBookBtn = document.getElementById('add-book-btn');
    const bookRowTemplate = booksContainer.querySelector('.book-row').cloneNode(true);
    
    // Clear template values
    bookRowTemplate.querySelector('.book-select').selectedIndex = 0;
    bookRowTemplate.querySelector('.quantity-input').value = '';

    addBookBtn.addEventListener('click', function () {
        const newBookRow = bookRowTemplate.cloneNode(true);
        newBookRow.querySelector('.book-select').name = `books[${bookRowIndex}][id]`;
        newBookRow.querySelector('.quantity-input').name = `books[${bookRowIndex}][quantity]`;
        booksContainer.appendChild(newBookRow);
        bookRowIndex++;
    });

    booksContainer.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-book-btn')) {
            // Do not remove the last book row
            if (booksContainer.querySelectorAll('.book-row').length > 1) {
                e.target.closest('.book-row').remove();
            }
        }
    });

    booksContainer.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('book-select')) {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const maxQuantity = selectedOption.getAttribute('data-quantity');
            const quantityInput = e.target.closest('.book-row').querySelector('.quantity-input');
            if (maxQuantity) {
                quantityInput.max = maxQuantity;
            }
        }
    });
});
</script>
@endpush 