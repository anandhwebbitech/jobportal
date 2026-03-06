@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
    <main class="main" id="main">

        <div class="glass-container">
            <!-- ===================== TOP METRICS ===================== -->
            <div class="row g-4 mb-4">

                <!-- Total Revenue -->
                <div class="col-xl-3 col-md-6">
                    <div class="gloss d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block mb-1">Total Revenue</small>
                            <h4 class="fw-bold mb-0">₹ {{ number_format($totalRevenue ?? 0, 2) }}</h4>
                            <small class="text-success">
                                <i class="fa fa-arrow-up me-1"></i>This Month
                            </small>
                        </div>
                        <div class="metric-icon text-success">
                            <i class="fa fa-indian-rupee-sign"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="col-xl-3 col-md-6">
                    <div class="gloss d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block mb-1">Total Orders</small>
                            <h4 class="fw-bold mb-0">{{ $orderCount ?? 0 }}</h4>
                            <small class="text-primary">
                                <i class="fa fa-shopping-cart me-1"></i>All Orders
                            </small>
                        </div>
                        <div class="metric-icon text-primary">
                            <i class="fa fa-cart-shopping"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Customers -->
                <div class="col-xl-3 col-md-6">
                    <div class="gloss d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block mb-1">Customers</small>
                            <h4 class="fw-bold mb-0">{{ $customerCount ?? 0 }}</h4>
                            <small class="text-info">
                                <i class="fa fa-users me-1"></i>Registered Users
                            </small>
                        </div>
                        <div class="metric-icon text-info">
                            <i class="fa fa-user-group"></i>
                        </div>
                    </div>
                </div>

                <!-- Low Stock -->
                <div class="col-xl-3 col-md-6">
                    <div class="gloss d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block mb-1">Low Stock</small>
                            <h4 class="fw-bold mb-0 text-danger">{{ $lowStockCount ?? 0 }}</h4>
                            <small class="text-danger">
                                <i class="fa fa-exclamation-triangle me-1"></i>Need Attention
                            </small>
                        </div>
                        <div class="metric-icon text-danger">
                            <i class="fa fa-box-open"></i>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ===================== SECOND ROW ===================== -->
            <div class="row g-4 mb-4">

                <!-- Categories -->
                <div class="col-xl-3 col-md-6">
                    <div class="gloss text-center">
                        <h6>Total Categories</h6>
                        <h3 class="fw-bold">{{ $categoryCount ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Products -->
                <div class="col-xl-3 col-md-6">
                    <div class="gloss text-center">
                        <h6>Total Products</h6>
                        <h3 class="fw-bold">{{ $productCount ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Colors -->
                <div class="col-xl-3 col-md-6">
                    <div class="gloss text-center">
                        <h6>Total Colors</h6>
                        <h3 class="fw-bold">{{ $colorCount ?? 0 }}</h3>
                    </div>
                </div>

                <!-- Sizes -->
                <div class="col-xl-3 col-md-6">
                    <div class="gloss text-center">
                        <h6>Total Sizes</h6>
                        <h3 class="fw-bold">{{ $sizeCount ?? 0 }}</h3>
                    </div>
                </div>

            </div>

            <!-- ===================== SALES CHART ===================== -->
            <div class="gloss mb-4">
                <h6 class="fw-semibold mb-3">Monthly Sales Overview</h6>
                <canvas id="salesChart" height="100"></canvas>
            </div>

            <!-- ===================== TOP PRODUCTS + RECENT ORDERS ===================== -->
            <div class="row g-4">

                <!-- Top Products -->
                <div class="col-md-6">
                    <div class="gloss">
                        <h6 class="fw-semibold mb-3">Top Selling Products</h6>
                        <ul class="list-group list-group-flush">
                            @forelse($topProducts ?? [] as $product)
                                <li class="list-group-item d-flex justify-content-between">
                                    {{ $product->name }}
                                    <span class="badge bg-success">{{ $product->total_sold }}</span>
                                </li>
                            @empty
                                <li class="list-group-item">No data available</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="col-md-6">
                    <div class="gloss">
                        <h6 class="fw-semibold mb-3">Recent Orders</h6>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders ?? [] as $order)
                                        <tr>
                                            <td>#{{ $order->id }}</td>
                                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                                            <td>
                                                <span
                                                    class="badge 
                                            {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>₹ {{ number_format($order->total, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">No recent orders</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($months ?? []) !!},
                datasets: [{
                    label: 'Sales',
                    data: {!! json_encode($monthlySales ?? []) !!},
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13,110,253,0.1)',
                    fill: true,
                    tension: 0.4
                }]
            }
        });
    </script>
@endpush
