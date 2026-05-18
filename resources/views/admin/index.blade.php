@extends('admin.layouts.master')
@section('title', 'Admin-Dashboard')
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
                            <h4 class="fw-bold mb-0">{{ $totalemployee->count() }}</h4>
                            <small class="text-success">
                                <i class="fa fa-arrow-up me-1"></i>
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
                            <h4 class="fw-bold mb-0">{{$totaljobseeker->count()}}</h4>
                            <small class="text-primary">
                                <i class="fa fa-users me-1"></i>

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
                            <h4 class="fw-bold mb-0">{{$livejobs->count()}}</h4>
                            <small class="text-info">
                                <i class="fa fa-shopping-cart me-1"></i>

                            </small>
                        </div>
                        <div class="metric-icon text-info">
                            <i class="fa fa-user-group"></i>
                        </div>
                    </div>
                </div>

                <!-- Low Stock -->
                

            </div>

            <!-- ===================== SECOND ROW ===================== -->
            
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
