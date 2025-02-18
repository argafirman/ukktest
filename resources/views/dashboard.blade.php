@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

        <!-- Row Statistik -->
        <div class="row">
            <!-- Total Pelanggan -->
            <div class="col-md-3">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-9">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Pelanggan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Pelanggan::count() }}
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <i class="fas fa-user fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Produk -->
            <div class="col-md-3">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-9">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Produk
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Produk::count() }}
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <i class="fas fa-box fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Penjualan -->
            <div class="col-md-3">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-9">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Total Penjualan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Penjualan::count() }}
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <i class="fas fa-shopping-cart fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Transaksi -->
            <div class="col-md-3">
                <div class="card shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col-md-9">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Transaksi
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ \App\Models\Transaksi::count() }}
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <i class="fas fa-money-bill-wave fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Statistik -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-primary">Grafik Penjualan Bulanan</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="penjualanChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-success">Grafik Pelanggan Baru</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="pelangganChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const penjualanCtx = document.getElementById('penjualanChart').getContext('2d');
            new Chart(penjualanCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Penjualan',
                        data: [150, 200, 250, 300, 280, 350],
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

            const pelangganCtx = document.getElementById('pelangganChart').getContext('2d');
            new Chart(pelangganCtx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Pelanggan Baru',
                        data: [30, 45, 60, 75, 90, 110],
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
