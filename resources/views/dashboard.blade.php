@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

        <!-- Stats Row -->
        <div class="row">
            <!-- Total Users -->
            <div class="col-md-3">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-9">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Users
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\User::count() }}
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Orders -->
            <div class="col-md-3">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-9">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Active Orders
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    120
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <i class="fas fa-shopping-cart fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue -->
            <div class="col-md-3">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-9">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Revenue
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    $12,345
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <i class="fas fa-dollar-sign fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed Tasks -->
            <div class="col-md-3">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-9">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Completed Tasks
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    75%
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <i class="fas fa-tasks fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                    datasets: [{
                        label: 'Revenue',
                        data: [1200, 1900, 3000, 5000, 2000, 3000],
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });

            const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
            new Chart(userGrowthCtx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                    datasets: [{
                        label: 'User Growth',
                        data: [50, 60, 70, 80, 90, 100],
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        </script>
    @endpush
@endsection