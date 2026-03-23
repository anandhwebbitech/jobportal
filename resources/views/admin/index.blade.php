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
                            <small class="text-muted d-block mb-1">Total Employer</small>
                            <h4 class="fw-bold mb-0">₹ 100</h4>
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
                            <small class="text-muted d-block mb-1">Total Job Seeker</small>
                            <h4 class="fw-bold mb-0">100</h4>
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
                            <small class="text-muted d-block mb-1">Live Jobs</small>
                            <h4 class="fw-bold mb-0">100</h4>
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
                            <small class="text-muted d-block mb-1"> Stock</small>
                            <h4 class="fw-bold mb-0 text-danger">100</h4>
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
                        <h3 class="fw-bold">100</h3>
                    </div>
                </div>

                <!-- Products -->
                <div class="col-xl-3 col-md-6">
                    <div class="gloss text-center">
                        <h6>Total Products</h6>
                        <h3 class="fw-bold">100</h3>
                    </div>
                </div>

                <!-- Colors -->
                <div class="col-xl-3 col-md-6">
                    <div class="gloss text-center">
                        <h6>Total Colors</h6>
                        <h3 class="fw-bold">100</h3>
                    </div>
                </div>

                <!-- Sizes -->
                <div class="col-xl-3 col-md-6">
                    <div class="gloss text-center">
                        <h6>Total Sizes</h6>
                        <h3 class="fw-bold">100</h3>
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
