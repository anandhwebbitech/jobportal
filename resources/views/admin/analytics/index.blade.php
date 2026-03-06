@extends('admin.layouts.master')
@section('title', 'Analytics')
@section('content')
<main class="main">

    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold">E-Commerce Analytics</h3>
                <small class="text-muted">Dashboard / Analytics Overview</small>
            </div>
        </div>

        <!-- ================= SUMMARY CARDS ================= -->
        <div class="row g-4 mb-4">

            <div class="col-md-3">
                <div class="card shadow border-0 rounded-4 bg-primary text-white">
                    <div class="card-body">
                        <h6>Total Revenue</h6>
                        <h3 class="fw-bold">₹ {{ number_format($totalRevenue ?? 0, 2) }}</h3>
                        <small>This Month</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow border-0 rounded-4 bg-success text-white">
                    <div class="card-body">
                        <h6>Total Orders</h6>
                        <h3 class="fw-bold">{{ $totalOrders ?? 0 }}</h3>
                        <small>This Month</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow border-0 rounded-4 bg-warning text-dark">
                    <div class="card-body">
                        <h6>Total Customers</h6>
                        <h3 class="fw-bold">{{ $totalCustomers ?? 0 }}</h3>
                        <small>Registered Users</small>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow border-0 rounded-4 bg-danger text-white">
                    <div class="card-body">
                        <h6>Low Stock Items</h6>
                        <h3 class="fw-bold">{{ $lowStockCount ?? 0 }}</h3>
                        <small>Need Attention</small>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= CHARTS SECTION ================= -->
        <div class="row g-4 mb-4">

            <div class="col-md-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Monthly Revenue</h5>
                        <canvas id="revenueChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Orders Overview</h5>
                        <canvas id="orderChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= TABLES SECTION ================= -->
        <div class="row g-4">

            <div class="col-md-6">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Top Selling Products</h5>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Sold</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts ?? [] as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td><span class="badge bg-success">{{ $product->total_sold }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Recent Orders</h5>
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentOrders ?? [] as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                                        <td>₹ {{ number_format($order->total,2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No recent orders</td>
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
document.addEventListener("DOMContentLoaded", function() {

    // Revenue Line Chart
    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($months ?? []) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($monthlyRevenue ?? []) !!},
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78,115,223,0.1)',
                fill: true,
                tension: 0.4
            }]
        }
    });

    // Orders Pie Chart
    new Chart(document.getElementById('orderChart'), {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Completed', 'Cancelled'],
            datasets: [{
                data: [
                    {{ $pendingOrders ?? 0 }},
                    {{ $completedOrders ?? 0 }},
                    {{ $cancelledOrders ?? 0 }}
                ],
                backgroundColor: ['#f6c23e', '#1cc88a', '#e74a3b']
            }]
        }
    });

});
</script>

@endpush