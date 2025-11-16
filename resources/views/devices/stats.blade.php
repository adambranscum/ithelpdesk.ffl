<x-app-layout>

<div class="container shadow mt-4 py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">
                    Device Inventory Statistics
                </h2>
                <a href="{{ route('devices.index') }}" class="btn btn-outline-secondary">
                    Back to Devices
                </a>
            </div>

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-primary mb-2">{{ $totalDevices }}</h3>
                            <p class="text-muted mb-0">Total Devices</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 bg-success bg-opacity-10">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-success mb-2">{{ $warrantyActive }}</h3>
                            <p class="text-muted mb-0">Active Warranties</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 bg-warning bg-opacity-10">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-warning mb-2">{{ $warrantyExpiringSoon }}</h3>
                            <p class="text-muted mb-0">Expiring Soon</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 bg-danger bg-opacity-10">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-danger mb-2">{{ $warrantyExpired }}</h3>
                            <p class="text-muted mb-0">Expired Warranties</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <h3 class="display-5 fw-bold text-primary mb-2">{{ number_format($avgDeviceAge, 1) }}</h3>
                            <p class="text-muted mb-0">Average Device Age (Years)</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <h3 class="display-5 fw-bold text-primary mb-2">{{ $devicesWithWarranty }}</h3>
                            <p class="text-muted mb-0">Devices with Warranty Info</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <h3 class="display-5 fw-bold text-primary mb-2">{{ $noWarrantyInfo }}</h3>
                            <p class="text-muted mb-0">No Warranty Info</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1 -->
            <div class="row g-3 mb-4">
                <!-- Warranty Status -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Warranty Status Distribution</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="warrantyStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Devices by Branch -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Devices by Branch</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="branchChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 2 -->
            <div class="row g-3 mb-4">
                <!-- Devices by Make -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Devices by Manufacturer</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="makeChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Top 10 Models -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Top 10 Device Models</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="modelChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 3 -->
            <div class="row g-3 mb-4">
                <!-- Purchases by Year -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Device Purchases by Year</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="yearChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Recent Purchases (Last 12 Months) -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Recent Purchases (Last 12 Months)</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="monthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 4 -->
            <div class="row g-3 mb-4">
                <!-- Warranty Expiring (Next 12 Months) -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Warranties Expiring (Next 12 Months)</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="warrantyExpiringChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Average Age by Make -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Average Device Age by Manufacturer</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="ageByMakeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 5 -->
            <div class="row g-3 mb-4">
                <!-- Warranty Type Distribution -->
                @if($devicesByWarranty->isNotEmpty())
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Warranty Type Distribution</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="warrantyTypeChart"></canvas>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Branch Warranty Breakdown -->
                <div class="col-lg-{{ $devicesByWarranty->isNotEmpty() ? '6' : '12' }}">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Branch Warranty Status</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Branch</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center text-success">Active</th>
                                            <th class="text-center text-warning">Expiring</th>
                                            <th class="text-center text-danger">Expired</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($branchWarrantyBreakdown as $branch)
                                        <tr>
                                            <td class="fw-semibold">{{ $branch->branch }}</td>
                                            <td class="text-center">{{ $branch->total }}</td>
                                            <td class="text-center text-success">{{ $branch->active }}</td>
                                            <td class="text-center text-warning">{{ $branch->expiring_soon }}</td>
                                            <td class="text-center text-danger">{{ $branch->expired }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Device Age Info -->
            @if($oldestDevice || $newestDevice)
            <div class="row g-3 mb-4">
                @if($oldestDevice)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Oldest Device</h5>
                            <p class="mb-1"><strong>{{ $oldestDevice->device_name }}</strong></p>
                            <p class="mb-1 text-muted">{{ $oldestDevice->make }} {{ $oldestDevice->model }}</p>
                            <p class="mb-0 text-muted">Purchased: {{ $oldestDevice->purchased ? \Carbon\Carbon::parse($oldestDevice->purchased)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                @endif
                @if($newestDevice)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Newest Device</h5>
                            <p class="mb-1"><strong>{{ $newestDevice->device_name }}</strong></p>
                            <p class="mb-1 text-muted">{{ $newestDevice->make }} {{ $newestDevice->model }}</p>
                            <p class="mb-0 text-muted">Purchased: {{ $newestDevice->purchased ? \Carbon\Carbon::parse($newestDevice->purchased)->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endif

        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Prepare data
    const branchData = @json($devicesByBranch);
    const makeData = @json($devicesByMake);
    const modelData = @json($devicesByModel);
    const yearData = @json($devicesByYear);
    const monthData = @json($devicesByMonth);
    const warrantyExpiringData = @json($warrantyExpiringByMonth);
    const avgAgeData = @json($avgAgeByMake);
    const warrantyTypeData = @json($devicesByWarranty);

    // Color palette
    const colors = [
        '#667eea', '#764ba2', '#f093fb', '#4facfe',
        '#43e97b', '#fa709a', '#fee140', '#30cfd0',
        '#a8edea', '#fed6e3'
    ];

    // Warranty Status Chart
    new Chart(document.getElementById('warrantyStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Expiring Soon', 'Expired', 'No Info'],
            datasets: [{
                data: [{{ $warrantyActive }}, {{ $warrantyExpiringSoon }}, {{ $warrantyExpired }}, {{ $noWarrantyInfo }}],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });

    // Branch Chart
    new Chart(document.getElementById('branchChart'), {
        type: 'bar',
        data: {
            labels: branchData.map(d => d.branch),
            datasets: [{
                label: 'Devices',
                data: branchData.map(d => d.count),
                backgroundColor: colors[0]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Make Chart
    new Chart(document.getElementById('makeChart'), {
        type: 'pie',
        data: {
            labels: makeData.map(d => d.make),
            datasets: [{
                data: makeData.map(d => d.count),
                backgroundColor: colors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });

    // Model Chart
    new Chart(document.getElementById('modelChart'), {
        type: 'bar',
        data: {
            labels: modelData.map(d => `${d.make} ${d.model}`),
            datasets: [{
                label: 'Devices',
                data: modelData.map(d => d.count),
                backgroundColor: colors[1]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            indexAxis: 'y',
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Year Chart
    new Chart(document.getElementById('yearChart'), {
        type: 'bar',
        data: {
            labels: yearData.map(d => d.year),
            datasets: [{
                label: 'Devices Purchased',
                data: yearData.map(d => d.count),
                backgroundColor: colors[2]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Month Chart
    new Chart(document.getElementById('monthChart'), {
        type: 'line',
        data: {
            labels: monthData.map(d => d.month),
            datasets: [{
                label: 'Devices Purchased',
                data: monthData.map(d => d.count),
                borderColor: colors[0],
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });

    // Warranty Expiring Chart
    new Chart(document.getElementById('warrantyExpiringChart'), {
        type: 'line',
        data: {
            labels: warrantyExpiringData.map(d => d.month),
            datasets: [{
                label: 'Warranties Expiring',
                data: warrantyExpiringData.map(d => d.count),
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });

    // Age by Make Chart
    new Chart(document.getElementById('ageByMakeChart'), {
        type: 'bar',
        data: {
            labels: avgAgeData.map(d => d.make),
            datasets: [{
                label: 'Average Age (Years)',
                data: avgAgeData.map(d => parseFloat(d.avg_age).toFixed(1)),
                backgroundColor: colors[3]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            indexAxis: 'y',
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Warranty Type Chart (if data exists)
    @if($devicesByWarranty->isNotEmpty())
    new Chart(document.getElementById('warrantyTypeChart'), {
        type: 'doughnut',
        data: {
            labels: warrantyTypeData.map(d => d.warranty),
            datasets: [{
                data: warrantyTypeData.map(d => d.count),
                backgroundColor: colors
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });
    @endif
</script>

</x-app-layout>