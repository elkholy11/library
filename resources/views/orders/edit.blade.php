@extends('dashboard.layout')

@section('title', __('dashboard.edit_order'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.edit_order') #{{ $order->id }}</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5>@lang('dashboard.order_details')</h5>
                    <p><strong>@lang('dashboard.user'):</strong> {{ $order->user->name }}</p>
                    <p><strong>@lang('dashboard.order_date'):</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>@lang('dashboard.total_price'):</strong> @money($order->total_price, 'SAR')</p>
                </div>
            </div>

            <hr>

            <h5>@lang('dashboard.ordered_books')</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>@lang('dashboard.book')</th>
                            <th>@lang('dashboard.quantity')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->pivot->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <hr>
            
            <form action="{{ route('dashboard.orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <!-- Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">@lang('dashboard.order_status')</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="pending" @selected($order->status == 'pending')>@lang('dashboard.pending')</option>
                        <option value="approved" @selected($order->status == 'approved')>@lang('dashboard.approved')</option>
                        <option value="rejected" @selected($order->status == 'rejected')>@lang('dashboard.rejected')</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">@lang('dashboard.save_changes')</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
            </form>
        </div>
    </div>
</div>
@endsection
