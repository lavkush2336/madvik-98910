<?php
session_start();
include '../connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // header("Location: login.php");
    // exit();
}

// Sample reports data
$sales_data = [
    ['month' => 'Jan', 'sales' => 125000, 'orders' => 45],
    ['month' => 'Feb', 'sales' => 145000, 'orders' => 52],
    ['month' => 'Mar', 'sales' => 135000, 'orders' => 48],
    ['month' => 'Apr', 'sales' => 165000, 'orders' => 58],
    ['month' => 'May', 'sales' => 155000, 'orders' => 55],
    ['month' => 'Jun', 'sales' => 185000, 'orders' => 65],
    ['month' => 'Jul', 'sales' => 175000, 'orders' => 62],
    ['month' => 'Aug', 'sales' => 195000, 'orders' => 68],
    ['month' => 'Sep', 'sales' => 185000, 'orders' => 65],
    ['month' => 'Oct', 'sales' => 205000, 'orders' => 72],
    ['month' => 'Nov', 'sales' => 225000, 'orders' => 78],
    ['month' => 'Dec', 'sales' => 245000, 'orders' => 85]
];

$category_sales = [
    ['category' => 'Sarees', 'sales' => 35, 'revenue' => 87500],
    ['category' => 'Lehengas', 'sales' => 20, 'revenue' => 70000],
    ['category' => 'Kurtis', 'sales' => 25, 'revenue' => 37500],
    ['category' => 'Dresses', 'sales' => 15, 'revenue' => 27000],
    ['category' => 'Accessories', 'sales' => 5, 'revenue' => 8000]
];

$top_products = [
    ['name' => 'Silk Saree - Traditional Red', 'sales' => 45, 'revenue' => 54000],
    ['name' => 'Bridal Lehenga - Gold', 'sales' => 32, 'revenue' => 112000],
    ['name' => 'Cotton Kurti - Blue Floral', 'sales' => 58, 'revenue' => 26100],
    ['name' => 'Party Dress - Black', 'sales' => 28, 'revenue' => 50400],
    ['name' => 'Silver Jewelry Set', 'sales' => 42, 'revenue' => 33600]
];

$customer_metrics = [
    ['metric' => 'Total Customers', 'value' => 1250, 'change' => '+12%'],
    ['metric' => 'New Customers', 'value' => 85, 'change' => '+8%'],
    ['metric' => 'Repeat Customers', 'value' => 420, 'change' => '+15%'],
    ['metric' => 'Average Order Value', 'value' => 2899, 'change' => '+5%']
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports & Analytics - ManavikFab Admin</title>
    <meta name="description" content="View comprehensive business reports, sales analytics, and performance metrics in the ManavikFab admin panel">
    <meta name="keywords" content="admin reports, business analytics, sales reports, e-commerce admin">
    <meta name="author" content="ManavikFab">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Poppins', sans-serif;
        }
        
        .admin-sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            z-index: 1000;
            overflow-y: auto;
        }
        
        .admin-content {
            margin-left: 240px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .sidebar-link {
            color: #6c757d;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        
        .sidebar-link:hover, .sidebar-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateX(5px);
        }
        
        .sidebar-link i {
            margin-right: 10px;
            width: 20px;
        }
        
        .report-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .report-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .metric-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }
        
        .metric-card:hover {
            transform: translateY(-3px);
        }
        
        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            border-radius: 10px;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            margin: 20px 0;
        }
        
        .positive-change { color: #28a745; }
        .negative-change { color: #dc3545; }
        
        .filter-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 admin-sidebar min-vh-100 p-0">
                <div class="p-4">
                    <h4 class="text-center mb-4">
                        <i class="bi bi-shop text-primary"></i>
                        ManavikFab
                    </h4>
                    
                    <nav class="nav flex-column">
                        <a href="index.php" class="sidebar-link">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                        <a href="orders.php" class="sidebar-link">
                            <i class="bi bi-cart-check"></i> Orders
                        </a>
                        <a href="products.php" class="sidebar-link">
                            <i class="bi bi-box"></i> Products
                        </a>
                        <a href="customers.php" class="sidebar-link">
                            <i class="bi bi-people"></i> Customers
                        </a>
                        <a href="categories.php" class="sidebar-link">
                            <i class="bi bi-tags"></i> Categories
                        </a>
                        <a href="inventory.php" class="sidebar-link">
                            <i class="bi bi-boxes"></i> Inventory
                        </a>
                        <a href="reports.php" class="sidebar-link active">
                            <i class="bi bi-graph-up"></i> Reports
                        </a>
                        <a href="settings.php" class="sidebar-link">
                            <i class="bi bi-gear"></i> Settings
                        </a>
                    </nav>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 admin-content p-4">
                <div class="admin-content p-4">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="mb-1">
                                <i class="bi bi-graph-up text-primary me-2"></i>
                                Reports & Analytics
                            </h2>
                            <p class="text-muted mb-0">Comprehensive business insights and performance metrics</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-custom">
                                <i class="bi bi-download me-2"></i>Export Report
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-calendar me-2"></i>Date Range
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-person-circle me-2"></i>Admin
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="../logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Key Metrics -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="metric-card p-3 text-center">
                                <i class="bi bi-currency-rupee text-success" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1">₹<?php echo number_format(array_sum(array_column($sales_data, 'sales'))); ?></h4>
                                <small class="text-muted">Total Revenue</small>
                                <div class="mt-2">
                                    <span class="positive-change">+15% <i class="bi bi-arrow-up"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="metric-card p-3 text-center">
                                <i class="bi bi-cart-check text-primary" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1"><?php echo array_sum(array_column($sales_data, 'orders')); ?></h4>
                                <small class="text-muted">Total Orders</small>
                                <div class="mt-2">
                                    <span class="positive-change">+8% <i class="bi bi-arrow-up"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="metric-card p-3 text-center">
                                <i class="bi bi-people text-info" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1"><?php echo $customer_metrics[0]['value']; ?></h4>
                                <small class="text-muted">Total Customers</small>
                                <div class="mt-2">
                                    <span class="positive-change">+12% <i class="bi bi-arrow-up"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="metric-card p-3 text-center">
                                <i class="bi bi-graph-up text-warning" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1">₹<?php echo number_format($customer_metrics[3]['value']); ?></h4>
                                <small class="text-muted">Avg Order Value</small>
                                <div class="mt-2">
                                    <span class="positive-change">+5% <i class="bi bi-arrow-up"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filters -->
                    <div class="filter-card p-4 mb-4">
                        <h5 class="mb-3"><i class="bi bi-funnel me-2"></i>Report Filters</h5>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Date Range</label>
                                <select class="form-select">
                                    <option value="last-30">Last 30 Days</option>
                                    <option value="last-90">Last 90 Days</option>
                                    <option value="last-6-months">Last 6 Months</option>
                                    <option value="last-year">Last Year</option>
                                    <option value="custom">Custom Range</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select">
                                    <option value="">All Categories</option>
                                    <option value="sarees">Sarees</option>
                                    <option value="lehengas">Lehengas</option>
                                    <option value="kurtis">Kurtis</option>
                                    <option value="dresses">Dresses</option>
                                    <option value="accessories">Accessories</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Report Type</label>
                                <select class="form-select">
                                    <option value="sales">Sales Report</option>
                                    <option value="inventory">Inventory Report</option>
                                    <option value="customer">Customer Report</option>
                                    <option value="product">Product Report</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Export Format</label>
                                <select class="form-select">
                                    <option value="pdf">PDF</option>
                                    <option value="excel">Excel</option>
                                    <option value="csv">CSV</option>
                                </select>
                            </div>
                        </div>
                        <div class="text-end">
                            <button class="btn btn-custom me-2">
                                <i class="bi bi-search me-2"></i>Generate Report
                            </button>
                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                        </div>
                    </div>
                    
                    <!-- Charts Row 1 -->
                    <div class="row mb-4">
                        <div class="col-lg-8 mb-4">
                            <div class="report-card p-4">
                                <h5 class="mb-3">
                                    <i class="bi bi-graph-up me-2"></i>Sales Trend (Last 12 Months)
                                </h5>
                                <div class="chart-container">
                                    <canvas id="salesChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 mb-4">
                            <div class="report-card p-4">
                                <h5 class="mb-3">
                                    <i class="bi bi-pie-chart me-2"></i>Category Distribution
                                </h5>
                                <div class="chart-container">
                                    <canvas id="categoryChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Charts Row 2 -->
                    <div class="row mb-4">
                        <div class="col-lg-6 mb-4">
                            <div class="report-card p-4">
                                <h5 class="mb-3">
                                    <i class="bi bi-bar-chart me-2"></i>Top Products by Revenue
                                </h5>
                                <div class="chart-container">
                                    <canvas id="productsChart"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mb-4">
                            <div class="report-card p-4">
                                <h5 class="mb-3">
                                    <i class="bi bi-people me-2"></i>Customer Metrics
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Metric</th>
                                                <th>Value</th>
                                                <th>Change</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($customer_metrics as $metric): ?>
                                            <tr>
                                                <td><?php echo $metric['metric']; ?></td>
                                                <td>
                                                    <?php if(strpos($metric['metric'], 'Value') !== false): ?>
                                                        ₹<?php echo number_format($metric['value']); ?>
                                                    <?php else: ?>
                                                        <?php echo number_format($metric['value']); ?>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="<?php echo strpos($metric['change'], '+') !== false ? 'positive-change' : 'negative-change'; ?>">
                                                        <?php echo $metric['change']; ?>
                                                    </span>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Detailed Reports -->
                    <div class="row">
                        <div class="col-12">
                            <div class="report-card p-4">
                                <h5 class="mb-3">
                                    <i class="bi bi-table me-2"></i>Detailed Sales Report
                                </h5>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th>Sales (₹)</th>
                                                <th>Orders</th>
                                                <th>Avg Order Value</th>
                                                <th>Growth</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($sales_data as $index => $data): ?>
                                            <tr>
                                                <td><strong><?php echo $data['month']; ?></strong></td>
                                                <td>₹<?php echo number_format($data['sales']); ?></td>
                                                <td><?php echo $data['orders']; ?></td>
                                                <td>₹<?php echo number_format($data['sales'] / $data['orders']); ?></td>
                                                <td>
                                                    <?php if($index > 0): ?>
                                                        <?php 
                                                        $growth = (($data['sales'] - $sales_data[$index-1]['sales']) / $sales_data[$index-1]['sales']) * 100;
                                                        $growth_class = $growth >= 0 ? 'positive-change' : 'negative-change';
                                                        $growth_icon = $growth >= 0 ? 'bi-arrow-up' : 'bi-arrow-down';
                                                        ?>
                                                        <span class="<?php echo $growth_class; ?>">
                                                            <?php echo ($growth >= 0 ? '+' : ''); ?><?php echo round($growth, 1); ?>% 
                                                            <i class="bi <?php echo $growth_icon; ?>"></i>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted">-</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sales Trend Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_column($sales_data, 'month')); ?>,
                datasets: [{
                    label: 'Sales (₹)',
                    data: <?php echo json_encode(array_column($sales_data, 'sales')); ?>,
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Orders',
                    data: <?php echo json_encode(array_column($sales_data, 'orders')); ?>,
                    borderColor: '#764ba2',
                    backgroundColor: 'rgba(118, 75, 162, 0.1)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Sales (₹)'
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Orders'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                    }
                }
            }
        });
        
        // Category Distribution Chart
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_column($category_sales, 'category')); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_column($category_sales, 'revenue')); ?>,
                    backgroundColor: [
                        '#667eea',
                        '#764ba2',
                        '#f093fb',
                        '#f5576c',
                        '#4facfe'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Top Products Chart
        const productsCtx = document.getElementById('productsChart').getContext('2d');
        new Chart(productsCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($top_products, 'name')); ?>,
                datasets: [{
                    label: 'Revenue (₹)',
                    data: <?php echo json_encode(array_column($top_products, 'revenue')); ?>,
                    backgroundColor: 'rgba(102, 126, 234, 0.8)',
                    borderColor: '#667eea',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Revenue (₹)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
        
        // Add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Reports page loaded');
        });
    </script>
</body>
</html> 