@extends('dashboard.layout')

@section('title', __('dashboard.order_details'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.order_details')</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">@lang('dashboard.back')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>@lang('dashboard.order_user'):</strong> {{ $order->user->name ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>@lang('dashboard.order_book'):</strong> {{ $order->book->title ?? 'N/A' }}</li>
                <li class="list-group-item"><strong>@lang('dashboard.order_date'):</strong> {{ $order->created_at->format('M d, Y') }}</li>
                <li class="list-group-item">
                    <strong>@lang('dashboard.order_status'):</strong>
                    @if($order->status == 'completed')
                        <span class="badge bg-success">@lang('dashboard.completed')</span>
                    @elseif($order->status == 'canceled')
                        <span class="badge bg-danger">@lang('dashboard.canceled')</span>
                    @else
                        <span class="badge bg-warning text-dark">@lang('dashboard.pending')</span>
                    @endif
                </li>
            </ul>
            <div class="mt-4">
                <a href="{{ route('dashboard.orders.edit', $order->id) }}" class="btn btn-primary">@lang('dashboard.edit')</a>
            </div>
        </div>
    </div>
</div>
@endsection 