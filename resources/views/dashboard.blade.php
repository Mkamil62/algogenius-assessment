<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: #212529;
            padding-top: 20px;
            z-index: 1000;
        }
        .sidebar .brand {
            padding: 20px;
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
            border-bottom: 1px solid #343a40;
            margin-bottom: 20px;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background-color: #343a40;
            color: #fff;
        }
        .sidebar .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        .main-content {
            margin-left: 250px;
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .stat-card {
            text-align: center;
            padding: 20px;
        }
        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #0d6efd;
        }
        .stat-label {
            color: #6c757d;
            font-size: 0.9rem;
            text-transform: uppercase;
        }
        .chart-container {
            position: relative;
            height: 400px;
            padding: 20px;
        }
        .loader {
            text-align: center;
            padding: 50px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="brand">
            <i class="bi bi-bar-chart-fill"></i> AlgoGenius
        </div>
        <nav class="nav flex-column">
            <a class="nav-link active" href="/dashboard">
                <i class="bi bi-house-door-fill"></i>
                Home
            </a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1 class="mb-4">Analytics Dashboard</h1>
        
        <!-- Summary Cards -->
        <div class="row" id="summary-cards">
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="loader">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="loader">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="loader">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stat-card">
                    <div class="loader">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Trend Chart -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sales Trend (Last 30 Days)</h5>
                        <div class="chart-container">
                            <canvas id="salesTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products Chart -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Products by Revenue</h5>
                        <div class="chart-container">
                            <canvas id="topProductsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Main Content -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Fetch and display summary data
        fetch('/api/analytics/summary')
            .then(response => response.json())
            .then(data => {
                document.getElementById('summary-cards').innerHTML = `
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="stat-value">${data.total_users}</div>
                            <div class="stat-label">Total Users</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="stat-value">${data.total_orders}</div>
                            <div class="stat-label">Total Orders</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="stat-value">$${data.total_revenue.toLocaleString()}</div>
                            <div class="stat-label">Total Revenue</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card stat-card">
                            <div class="stat-value">$${data.average_order_value.toFixed(2)}</div>
                            <div class="stat-label">Avg Order Value</div>
                        </div>
                    </div>
                `;
            })
            .catch(error => console.error('Error fetching summary:', error));

        // Fetch and display sales trend chart
        fetch('/api/analytics/sales-trend')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('salesTrendChart').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Revenue ($)',
                            data: data.values,
                            borderColor: '#0d6efd',
                            backgroundColor: 'rgba(13, 110, 253, 0.1)',
                            tension: 0.4,
                            fill: true
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
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching sales trend:', error));

        // Fetch and display top products chart
        fetch('/api/analytics/top-products')
            .then(response => response.json())
            .then(data => {
                const ctx = document.getElementById('topProductsChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Revenue ($)',
                            data: data.values,
                            backgroundColor: [
                                'rgba(13, 110, 253, 0.8)',
                                'rgba(25, 135, 84, 0.8)',
                                'rgba(255, 193, 7, 0.8)',
                                'rgba(220, 53, 69, 0.8)',
                                'rgba(111, 66, 193, 0.8)'
                            ],
                            borderColor: [
                                'rgb(13, 110, 253)',
                                'rgb(25, 135, 84)',
                                'rgb(255, 193, 7)',
                                'rgb(220, 53, 69)',
                                'rgb(111, 66, 193)'
                            ],
                            borderWidth: 2
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
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching top products:', error));
    </script>
</body>
</html>