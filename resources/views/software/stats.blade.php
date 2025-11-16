<x-app-layout>

<div class="container shadow mt-4 py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">
                    Software License Statistics
                </h2>
                <a href="{{ route('software.index') }}" class="btn btn-outline-secondary">
                    Back to Software
                </a>
            </div>

            <!-- Summary Cards - Software Count -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-primary mb-2">{{ $totalSoftware }}</h3>
                            <p class="text-muted mb-0">Total Software</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 bg-success bg-opacity-10">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-success mb-2">{{ $licensesActive }}</h3>
                            <p class="text-muted mb-0">Active Licenses</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 bg-warning bg-opacity-10">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-warning mb-2">{{ $licensesExpiringSoon }}</h3>
                            <p class="text-muted mb-0">Expiring Soon</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 bg-danger bg-opacity-10">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-danger mb-2">{{ $licensesExpired }}</h3>
                            <p class="text-muted mb-0">Expired Licenses</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards - License Quantities -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-primary mb-2">{{ number_format($totalLicenses) }}</h3>
                            <p class="text-muted mb-0">Total Licenses</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 bg-success bg-opacity-10">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-success mb-2">{{ number_format($totalLicensesActive) }}</h3>
                            <p class="text-muted mb-0">Active License Count</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 bg-warning bg-opacity-10">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-warning mb-2">{{ number_format($totalLicensesExpiringSoon) }}</h3>
                            <p class="text-muted mb-0">Expiring License Count</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 bg-danger bg-opacity-10">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-danger mb-2">{{ number_format($totalLicensesExpired) }}</h3>
                            <p class="text-muted mb-0">Expired License Count</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Stats Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <h3 class="display-5 fw-bold text-primary mb-2">{{ number_format($avgLicensesPerSoftware ?? 0, 1) }}</h3>
                            <p class="text-muted mb-0">Avg Licenses per Software</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <h3 class="display-5 fw-bold text-primary mb-2">{{ $softwareWithRenewalInfo }}</h3>
                            <p class="text-muted mb-0">Software with Renewal Info</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <h3 class="display-5 fw-bold text-primary mb-2">{{ $noRenewalInfo }}</h3>
                            <p class="text-muted mb-0">No Renewal Info</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Renewals Alert -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 border-start border-danger border-4">
                        <div class="card-body text-center">
                            <h3 class="display-5 fw-bold text-danger mb-2">{{ $renewalsNext30Days->count() }}</h3>
                            <p class="text-muted mb-0">Renewals in Next 30 Days</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 border-start border-warning border-4">
                        <div class="card-body text-center">
                            <h3 class="display-5 fw-bold text-warning mb-2">{{ $renewalsNext60Days }}</h3>
                            <p class="text-muted mb-0">Renewals in 31-60 Days</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 border-start border-info border-4">
                        <div class="card-body text-center">
                            <h3 class="display-5 fw-bold text-info mb-2">{{ $renewalsNext90Days }}</h3>
                            <p class="text-muted mb-0">Renewals in 61-90 Days</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 1 -->
            <div class="row g-3 mb-4">
                <!-- License Status -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">License Status Distribution (Software Count)</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="licenseStatusChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- License Quantity Status -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">License Status Distribution (Total Licenses)</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="licenseQuantityChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 2 -->
            <div class="row g-3 mb-4">
                <!-- Top 10 Software by Licenses -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Top 10 Software by License Count</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="topSoftwareChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- License Distribution Ranges -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">License Quantity Distribution</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="licenseRangesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 3 -->
            <div class="row g-3 mb-4">
                <!-- Renewals by Month (Next 12) -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Upcoming Renewals (Next 12 Months)</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="renewalsByMonthChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Renewals by Year -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Renewals by Year</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="renewalsByYearChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 4 -->
            <div class="row g-3 mb-4">
                <!-- Software Added by Month -->
                <div class="col-lg-12">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Software Added (Last 12 Months)</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="softwareAddedChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Renewals Table -->
            @if($renewalsNext30Days->isNotEmpty())
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">
                                Urgent: Renewals Due in Next 30 Days
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Software</th>
                                            <th class="text-center">Licenses</th>
                                            <th class="text-center">Renewal Date</th>
                                            <th class="text-center">Days Until Renewal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($renewalsNext30Days as $software)
                                        <tr>
                                            <td class="fw-semibold">
                                                <a href="{{ route('software.edit', $software) }}" class="text-decoration-none">
                                                    {{ $software->software }}
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                @if($software->unlimited == 1)
                                                    <span class="text-muted">&infin;</span>
                                                @else
                                                    {{ number_format($software->licence_quantity) }}
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $software->renewal_date->format('M d, Y') }}</td>
                                            <td class="text-center">
                                                @php
                                                    $daysUntil = now()->diffInDays($software->renewal_date, false);
                                                @endphp
                                                <span class="badge {{ $daysUntil <= 7 ? 'bg-danger' : 'bg-warning' }}">
                                                    {{ $daysUntil }} days
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- License Extremes Info -->
            <div class="row g-3 mb-4">
                @if($mostLicensed)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Most Licensed Software</h5>
                            <p class="mb-1"><strong>{{ $mostLicensed->software }}</strong></p>
                            <p class="mb-0 text-muted">{{ number_format($mostLicensed->licence_quantity) }} licenses</p>
                        </div>
                    </div>
                </div>
                @endif
                @if($leastLicensed)
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Least Licensed Software</h5>
                            <p class="mb-1"><strong>{{ $leastLicensed->software }}</strong></p>
                            <p class="mb-0 text-muted">{{ number_format($leastLicensed->licence_quantity) }} licenses</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Prepare data
    const softwareByLicensesData = @json($softwareByLicenses);
    const renewalsByMonthData = @json($renewalsByMonth);
    const renewalsByYearData = @json($renewalsByYear);
    const softwareAddedData = @json($softwareAddedByMonth);
    const licenseRangesData = @json($licenseRanges);

    // Color palette
    const colors = [
        '#667eea', '#764ba2', '#f093fb', '#4facfe',
        '#43e97b', '#fa709a', '#fee140', '#30cfd0',
        '#a8edea', '#fed6e3'
    ];

    // License Status Chart (Software Count)
    new Chart(document.getElementById('licenseStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Expiring Soon', 'Expired', 'No Info'],
            datasets: [{
                data: [{{ $licensesActive }}, {{ $licensesExpiringSoon }}, {{ $licensesExpired }}, {{ $noRenewalInfo }}],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // License Quantity Chart
    new Chart(document.getElementById('licenseQuantityChart'), {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Expiring Soon', 'Expired', 'No Info'],
            datasets: [{
                data: [{{ $totalLicensesActive }}, {{ $totalLicensesExpiringSoon }}, {{ $totalLicensesExpired }}, {{ $totalLicensesNoInfo }}],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545', '#6c757d']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Top Software Chart
    new Chart(document.getElementById('topSoftwareChart'), {
        type: 'bar',
        data: {
            labels: softwareByLicensesData.map(d => d.software),
            datasets: [{
                label: 'Licenses',
                data: softwareByLicensesData.map(d => d.licence_quantity),
                backgroundColor: colors[0]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            indexAxis: 'y',
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });

    // License Ranges Chart
    new Chart(document.getElementById('licenseRangesChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(licenseRangesData),
            datasets: [{
                label: 'Software Count',
                data: Object.values(licenseRangesData),
                backgroundColor: colors[1]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Renewals by Month Chart
    new Chart(document.getElementById('renewalsByMonthChart'), {
        type: 'line',
        data: {
            labels: renewalsByMonthData.map(d => d.month),
            datasets: [{
                label: 'Software Renewals',
                data: renewalsByMonthData.map(d => d.count),
                borderColor: colors[0],
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Renewals by Year Chart
    new Chart(document.getElementById('renewalsByYearChart'), {
        type: 'bar',
        data: {
            labels: renewalsByYearData.map(d => d.year),
            datasets: [{
                label: 'Software Renewals',
                data: renewalsByYearData.map(d => d.count),
                backgroundColor: colors[2]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Software Added Chart
    new Chart(document.getElementById('softwareAddedChart'), {
        type: 'line',
        data: {
            labels: softwareAddedData.map(d => d.month),
            datasets: [{
                label: 'Software Added',
                data: softwareAddedData.map(d => d.count),
                borderColor: colors[3],
                backgroundColor: 'rgba(79, 172, 254, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

</x-app-layout>