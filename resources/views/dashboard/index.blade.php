@extends('dashboard.layout')

@section('title', __('dashboard.home'))

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">@lang('dashboard.home')</h1>

        <!-- Stat Cards -->
        <div class="row">
            <!-- Books Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">@lang('dashboard.books')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['books'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-book fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Authors Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">@lang('dashboard.authors')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['authors'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-feather-alt fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Categories Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">@lang('dashboard.categories')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['categories'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-layer-group fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Users Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">@lang('dashboard.users')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['users'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Borrows Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">@lang('dashboard.borrows')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['borrows'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-hand-holding-heart fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Book Requests Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-secondary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">@lang('dashboard.book_requests')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['book_requests'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-inbox fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Card -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-dark shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">@lang('dashboard.orders')</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['orders'] }}</div>
                            </div>
                            <div class="col-auto"><i class="fas fa-shopping-cart fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">@lang('dashboard.library_statistics')</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="myBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myBarChart').getContext('2d');
    const myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [
                @json(__('dashboard.books')), 
                @json(__('dashboard.authors')),
                @json(__('dashboard.categories')),
                @json(__('dashboard.users')), 
                @json(__('dashboard.borrows')),
                @json(__('dashboard.book_requests')),
                @json(__('dashboard.orders'))
            ],
            datasets: [{
                label: 'Count',
                data: [
                    {{ $stats['books'] }}, 
                    {{ $stats['authors'] }}, 
                    {{ $stats['categories'] }}, 
                    {{ $stats['users'] }}, 
                    {{ $stats['borrows'] }},
                    {{ $stats['book_requests'] }},
                    {{ $stats['orders'] }}
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(201, 203, 207, 0.5)',
                    'rgba(0, 0, 0, 0.5)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(201, 203, 207, 1)',
                    'rgba(0, 0, 0, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
<style>
    .card.border-left-primary { border-left: .25rem solid #4e73df!important; }
    .card.border-left-success { border-left: .25rem solid #1cc88a!important; }
    .card.border-left-info { border-left: .25rem solid #36b9cc!important; }
    .card.border-left-warning { border-left: .25rem solid #f6c23e!important; }
    .card.border-left-danger { border-left: .25rem solid #e74a3b!important; }
    .card.border-left-secondary { border-left: .25rem solid #858796!important; }
    .card.border-left-dark { border-left: .25rem solid #5a5c69!important; }
</style>
@endpush 