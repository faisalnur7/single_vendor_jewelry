@extends('layouts.admin_master')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Overview')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/plugins/daterangepicker/daterangepicker.css') }}">
    <style>
        .stat-card {
            transition: all 0.3s ease;
            border: none;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 24px;
        }
        
        .stat-card .card-body {
            padding: 1.5rem;
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin: 0.5rem 0;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }
        
        .stat-change {
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }
        
        .stat-change.positive {
            color: #28a745;
        }
        
        .stat-change.negative {
            color: #dc3545;
        }
        
        .bg-gradient-primary { background: linear-gradient(45deg, #007bff, #0056b3) !important; color: white; }
        .bg-gradient-success { background: linear-gradient(45deg, #28a745, #1e7e34) !important; color: white; }
        .bg-gradient-warning { background: linear-gradient(45deg, #ffc107, #d39e00) !important; color: #212529; }
        .bg-gradient-danger { background: linear-gradient(45deg, #dc3545, #bd2130) !important; color: white; }
        .bg-gradient-info { background: linear-gradient(45deg, #17a2b8, #117a8b) !important; color: white; }
        .bg-gradient-purple { background: linear-gradient(45deg, #6f42c1, #59359a) !important; color: white; }
        .bg-gradient-dark { background: linear-gradient(45deg, #343a40, #1d2124) !important; color: white; }
        .bg-gradient-pink { background: linear-gradient(45deg, #e83e8c, #c5307b) !important; color: white; }
        
        .chart-container {
            position: relative;
            height: 300px;
        }
        
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        
        .status-badge {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            border-radius: 0.25rem;
        }
        
        .box {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }
        
        .box .box-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        
        .box .box-body {
            padding: 1.5rem;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
        }
        
        .card .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.25rem 1.5rem;
            font-weight: 600;
        }
        
        .card .card-body {
            padding: 1.5rem;
        }

        @media (max-width: 767px) {
            .stat-card {
                margin-bottom: 1rem;
            }
            .stat-value {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection

@section('contents')
<div class="container-fluid">
    
    <!-- Stat Cards Row -->
    <div class="row">
        <!-- Total Revenue -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <p class="stat-label text-white-50">Total Revenue</p>
                            <h3 class="stat-value text-white">{{ number_format($totalRevenue, 2) }}</h3>
                            <p class="stat-change text-white-50">
                                <small>This month: {{ number_format($monthRevenue, 2) }}</small>
                            </p>
                        </div>
                        <div class="stat-icon bg-white text-primary">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <p class="stat-label text-white-50">Total Orders</p>
                            <h3 class="stat-value text-white">{{ $totalOrders }}</h3>
                            <p class="stat-change text-white-50">
                                <small>Pending: {{ $pendingOrders }}</small>
                            </p>
                        </div>
                        <div class="stat-icon bg-white text-success">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <p class="stat-label">Total Products</p>
                            <h3 class="stat-value">{{ $totalProducts }}</h3>
                            <p class="stat-change positive">
                                <i class="fas fa-check-circle"></i> {{ $activeProducts }} active
                            </p>
                        </div>
                        <div class="stat-icon bg-dark text-warning">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-purple">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <p class="stat-label text-white-50">Total Customers</p>
                            <h3 class="stat-value text-white">{{ $totalCustomers }}</h3>
                            <p class="stat-change text-white-50">
                                <small>New today: {{ $todayCustomers }}</small>
                            </p>
                        </div>
                        <div class="stat-icon bg-white text-purple">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second Row: Today's Stats & Alerts -->
    <div class="row">
        <!-- Today's Revenue -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <p class="stat-label text-white-50">Today's Revenue</p>
                            <h3 class="stat-value text-white">{{ number_format($todayRevenue, 2) }}</h3>
                            <p class="stat-change text-white-50">
                                <small>{{ \Carbon\Carbon::today()->format('M d, Y') }}</small>
                            </p>
                        </div>
                        <div class="stat-icon bg-white text-info">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-xl-3 col-md-6">
            <div class="card stat-card bg-gradient-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <p class="stat-label text-white-50">Pending Orders</p>
                            <h3 class="stat-value text-white">{{ $pendingOrders }}</h3>
                            <p class="stat-change text-white-50">
                                <small>Requires attention</small>
                            </p>
                        </div>
                        <div class="stat-icon bg-white text-danger">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('product.list') }}" style="text-decoration: none;">
                <div class="card stat-card bg-gradient-orange" style="background: linear-gradient(45deg, #fd7e14, #e85d04) !important; color: white;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <p class="stat-label text-white-50">Low Stock</p>
                                <h3 class="stat-value text-white">{{ $lowStockProducts }}</h3>
                                <p class="stat-change text-white-50">
                                    <small>< 10 units</small>
                                </p>
                            </div>
                            <div class="stat-icon bg-white" style="color: #fd7e14;">
                                <i class="fas fa-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Out of Stock -->
        <div class="col-xl-3 col-md-6">
            <a href="{{ route('product.list') }}" style="text-decoration: none;">
                <div class="card stat-card bg-gradient-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-grow-1">
                                <p class="stat-label text-white-50">Out of Stock</p>
                                <h3 class="stat-value text-white">{{ $outOfStockProducts }}</h3>
                                <p class="stat-change text-white-50">
                                    <small>Needs restocking</small>
                                </p>
                            </div>
                            <div class="stat-icon bg-white text-dark">
                                <i class="fas fa-times-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Sales Chart -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-line mr-2"></i>Sales Overview (Last 7 Days)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Status Distribution -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie mr-2"></i>Order Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 250px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="mt-3 text-center">
                        @foreach($orderStatusData as $status => $count)
                            @if($count > 0)
                                <span class="badge mr-2 mb-2" style="background-color: {{ $statusColors[$status] }}20; color: {{ $statusColors[$status] }};">
                                    {{ ucfirst($status) }}: {{ $count }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Third Row: Recent Orders & Top Products -->
    <div class="row">
        <!-- Recent Orders -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-receipt mr-2"></i>Recent Orders
                    </h5>
                    <a href="{{ route('orders') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders as $order)
                                <tr>
                                    <td><strong>#{{ $order->order_tracking_number ?? $order->id }}</strong></td>
                                    <td>{{ $order->user->name ?? 'Guest/Deleted' }}</td>
                                    <td>{{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @php
                                            $statusColors = [
                                                1 => '#ffc107', // Pending
                                                2 => '#17a2b8', // Confirmed
                                                3 => '#dc3545', // Rejected
                                                4 => '#007bff', // Processing
                                                5 => '#6c757d', // Shipped
                                                6 => '#28a745', // Completed
                                            ];
                                            $color = is_numeric($order->status) ? ($statusColors[$order->status] ?? '#6c757d') : '#6c757d';
                                            $statusText = is_numeric($order->status) ? (\App\Models\Order::ORDER_STATUS[$order->status] ?? 'Unknown') : ucfirst(str_replace('_', ' ', $order->status));
                                        @endphp
                                        <span class="status-badge" style="background-color: {{ $color }}20; color: {{ $color }};">
                                            {{ $statusText }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No orders yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

                    <!-- Top Selling Products -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-trophy mr-2"></i>Top Selling Products
                                </h5>
                            </div>
                            <div class="card-body">
                                @if($topProducts->count())
                                @foreach($topProducts as $index => $item)
                                    @php
                                        $product = $item['product'];
                                        $rankColors = ['#ffd700', '#c0c0c0', '#cd7f32', '#007bff', '#6c757d'];
                                        $rankIcons = ['fa-medal', 'fa-medal', 'fa-medal', 'fa-award', 'fa-star'];
                                    @endphp
                                    @if($product)
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="mr-3" style="width: 40px; height: 40px; background: #f8f9fa; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas {{ $rankIcons[$index] ?? 'fa-star' }}" style="color: {{ $rankColors[$index] ?? '#6c757d' }};"></i>
                                                </div>
                                                <div>
                                                    <div class="font-weight-semibold">{{ \Illuminate\Support\Str::limit($item['product_name'], 30) }}</div>
                                                    <small class="text-muted">{{ $item['sku'] }}</small>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-weight-bold">{{ $item['total_sold'] }} units</div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @else
                                    <p class="text-muted text-center">No sales data available</p>
                                @endif
                            </div>
                        </div>
                    </div>
    </div>

    <!-- Fourth Row: Additional Stats -->
    <div class="row">
        <!-- Order Status Summary -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tasks mr-2"></i>Order Status Summary
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span><i class="fas fa-circle text-warning mr-2" style="font-size: 0.5rem;"></i> Pending</span>
                            <strong>{{ $pendingOrders }}</strong>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span><i class="fas fa-circle text-info mr-2" style="font-size: 0.5rem;"></i> Confirmed</span>
                            <strong>{{ $confirmedOrders }}</strong>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span><i class="fas fa-circle text-primary mr-2" style="font-size: 0.5rem;"></i> Processing</span>
                            <strong>{{ $processedOrders }}</strong>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span><i class="fas fa-circle text-secondary mr-2" style="font-size: 0.5rem;"></i> Shipped</span>
                            <strong>{{ $shippedOrders }}</strong>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span><i class="fas fa-circle text-success mr-2" style="font-size: 0.5rem;"></i> Delivered</span>
                            <strong>{{ $deliveredOrders }}</strong>
                        </li>
                        <li class="d-flex justify-content-between py-2">
                            <span><i class="fas fa-circle text-danger mr-2" style="font-size: 0.5rem;"></i> Cancelled</span>
                            <strong>{{ $cancelledOrders }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Product Inventory Status -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-boxes mr-2"></i>Inventory Status
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span>Total Products</span>
                            <strong>{{ $totalProducts }}</strong>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-success">Active</span>
                            <strong>{{ $activeProducts }}</strong>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-warning">Low Stock</span>
                            <strong>{{ $lowStockProducts }}</strong>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-danger">Out of Stock</span>
                            <strong>{{ $outOfStockProducts }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Customer Overview -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users mr-2"></i>Customer Overview
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span>Total Customers</span>
                            <strong>{{ $totalCustomers }}</strong>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span>Active Customers</span>
                            <strong>{{ $activeCustomers }}</strong>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span>New Today</span>
                            <strong>{{ $todayCustomers }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($last7Days);
    
    new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: salesData.map(d => d.date),
            datasets: [{
                label: 'Revenue ()',
                data: salesData.map(d => d.sales),
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Order Status Pie Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    const statusData = @json($orderStatusData);
    
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(statusData).map(k => k.charAt(0).toUpperCase() + k.slice(1)),
            datasets: [{
                data: Object.values(statusData),
                backgroundColor: [
                    '#ffc107', // pending - yellow
                    '#17a2b8', // confirmed - cyan
                    '#007bff', // processing - primary
                    '#6c757d', // shipped - secondary
                    '#28a745', // delivered - success
                    '#dc3545'  // cancelled - danger
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            cutout: '70%'
        }
    });
</script>
@endsection