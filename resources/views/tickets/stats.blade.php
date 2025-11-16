<x-app-layout>

<div class="container shadow mt-4 py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">
                    Ticket Statistics
                </h2>
                <a href="{{ route('tickets.index') }}" class="btn btn-outline-secondary">
                    Back to Tickets
                </a>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('tickets.stats') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label fw-semibold">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $startDate->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label fw-semibold">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $endDate->format('Y-m-d') }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-primary mb-2">{{ $totalTickets }}</h3>
                            <p class="text-muted mb-0">Total Tickets</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 bg-warning bg-opacity-10">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-warning mb-2">{{ $newTickets }}</h3>
                            <p class="text-muted mb-0">New Tickets</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 bg-info bg-opacity-10">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-info mb-2">{{ $inProgressTickets }}</h3>
                            <p class="text-muted mb-0">In Progress</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm h-100 bg-success bg-opacity-10">
                        <div class="card-body text-center">
                            <h3 class="display-4 fw-bold text-success mb-2">{{ $resolvedTickets }}</h3>
                            <p class="text-muted mb-0">Resolved</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resolution Time -->
            @if($avgResolutionTime)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body text-center">
                            <h3 class="display-5 fw-bold text-primary mb-2">{{ number_format($avgResolutionTime, 1) }} hours</h3>
                            <p class="text-muted mb-0">Average Resolution Time</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Charts Row 1 -->
            <div class="row g-3 mb-4">
                <!-- Tickets by Month -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Tickets by Month</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Tickets by Status -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Tickets by Status</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="statusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 2 -->
            <div class="row g-3 mb-4">
                <!-- Tickets by Usertype -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Tickets by Assigned Tech</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="usertypeChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Tickets by Problem Type -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Tickets by Problem Type</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="problemTypeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 3 -->
            <div class="row g-3 mb-4">
                <!-- Tickets by Device -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Top 10 Devices</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="deviceChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Tickets by Software -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Top 10 Software</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="softwareChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly by Usertype -->
            <div class="row g-3 mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">Monthly Tickets by Tech</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyUsertypeChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    // Prepare data
    const monthlyData = @json($ticketsByMonth);
    const usertypeData = @json($ticketsByUsertype);
    const deviceData = @json($ticketsByDevice);
    const softwareData = @json($ticketsBySoftware);
    const problemTypeData = @json($ticketsByProblemType);
    const statusData = @json($ticketsByStatus);
    const monthlyUsertypeData = @json($monthlyByUsertype);

    // Color palette
    const colors = [
        '#667eea', '#764ba2', '#f093fb', '#4facfe',
        '#43e97b', '#fa709a', '#fee140', '#30cfd0',
        '#a8edea', '#fed6e3'
    ];

    // Status colors
    const statusColors = {
        'new': '#ffc107',
        'in_progress': '#17a2b8',
        'resolved': '#28a745',
        'closed': '#6c757d'
    };

    // Monthly Chart
    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: monthlyData.map(d => d.month),
            datasets: [{
                label: 'Tickets',
                data: monthlyData.map(d => d.count),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4,
                fill: true
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

    // Status Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: statusData.map(d => d.status.charAt(0).toUpperCase() + d.status.slice(1).replace('_', ' ')),
            datasets: [{
                data: statusData.map(d => d.count),
                backgroundColor: statusData.map(d => statusColors[d.status] || '#667eea')
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });

    // Usertype Chart
    new Chart(document.getElementById('usertypeChart'), {
        type: 'bar',
        data: {
            labels: usertypeData.map(d => d.assigned_to),
            datasets: [{
                label: 'Tickets',
                data: usertypeData.map(d => d.count),
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

    // Problem Type Chart
    new Chart(document.getElementById('problemTypeChart'), {
        type: 'bar',
        data: {
            labels: problemTypeData.map(d => d.problem_type),
            datasets: [{
                label: 'Tickets',
                data: problemTypeData.map(d => d.count),
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

    // Device Chart
    new Chart(document.getElementById('deviceChart'), {
        type: 'bar',
        data: {
            labels: deviceData.map(d => d.device_name),
            datasets: [{
                label: 'Tickets',
                data: deviceData.map(d => d.count),
                backgroundColor: colors[2]
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

    // Software Chart
    new Chart(document.getElementById('softwareChart'), {
        type: 'bar',
        data: {
            labels: softwareData.map(d => d.software_name),
            datasets: [{
                label: 'Tickets',
                data: softwareData.map(d => d.count),
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

    // Monthly by Usertype Chart
    const uniqueUsertypes = [...new Set(monthlyUsertypeData.map(d => d.assigned_to))];
    const uniqueMonths = [...new Set(monthlyUsertypeData.map(d => d.month))];

    const monthlyUsertypeDatasets = uniqueUsertypes.map((usertype, index) => ({
        label: usertype,
        data: uniqueMonths.map(month => {
            const item = monthlyUsertypeData.find(d => d.month === month && d.assigned_to === usertype);
            return item ? item.count : 0;
        }),
        borderColor: colors[index % colors.length],
        backgroundColor: colors[index % colors.length],
        tension: 0.4
    }));

    new Chart(document.getElementById('monthlyUsertypeChart'), {
        type: 'line',
        data: {
            labels: uniqueMonths,
            datasets: monthlyUsertypeDatasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: true, position: 'bottom' }
            }
        }
    });
</script>

</x-app-layout>