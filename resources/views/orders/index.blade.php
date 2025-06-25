@extends('dashboard.layout')

@section('title', __('dashboard.order_list'))

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('dashboard.orders')</h1>
        <a href="{{ route('dashboard.orders.create') }}" class="btn btn-primary">@lang('dashboard.add_order')</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>@lang('dashboard.order_user')</th>
                            <th>@lang('dashboard.order_book')</th>
                            <th>@lang('dashboard.order_date')</th>
                            <th>@lang('dashboard.order_status')</th>
                            <th>@lang('dashboard.actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>{{ $order->books->first()->title ?? 'N/A' }} {{ $order->books->count() > 1 ? '... (and more)' : '' }}</td>
                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if($order->status == 'approved')
                                        <span class="badge bg-success">@lang('dashboard.approved')</span>
                                    @elseif($order->status == 'rejected')
                                        <span class="badge bg-danger">@lang('dashboard.rejected')</span>
                                    @elseif($order->status == 'pending')
                                        <span class="badge bg-warning text-dark">@lang('dashboard.pending')</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('dashboard.orders.show', $order->id) }}" class="btn btn-info btn-sm" title="@lang('dashboard.show')"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('dashboard.orders.edit', $order->id) }}" class="btn btn-primary btn-sm" title="@lang('dashboard.edit')"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('dashboard.orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('@lang('dashboard.confirm_delete')');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="mt-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 