<?php
session_start();
include '../connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // header("Location: login.php");
    // exit();
}

// Sample orders data
$orders = [
    [
        'id' => 'ORD001',
        'customer_name' => 'Priya Sharma',
        'customer_email' => 'priya.sharma@email.com',
        'order_date' => '2024-01-15',
        'total_amount' => 2499,
        'status' => 'Delivered',
        'payment_status' => 'Paid',
        'items' => 3,
        'shipping_address' => '123, Green Park, New Delhi - 110016'
    ],
    [
        'id' => 'ORD002',
        'customer_name' => 'Anjali Patel',
        'customer_email' => 'anjali.patel@email.com',
        'order_date' => '2024-01-14',
        'total_amount' => 1899,
        'status' => 'In Transit',
        'payment_status' => 'Paid',
        'items' => 2,
        'shipping_address' => '456, Sector 15, Gurgaon - 122001'
    ],
    [
        'id' => 'ORD003',
        'customer_name' => 'Meera Singh',
        'customer_email' => 'meera.singh@email.com',
        'order_date' => '2024-01-13',
        'total_amount' => 3299,
        'status' => 'Processing',
        'payment_status' => 'Pending',
        'items' => 4,
        'shipping_address' => '789, Andheri West, Mumbai - 400058'
    ],
    [
        'id' => 'ORD004',
        'customer_name' => 'Kavya Reddy',
        'customer_email' => 'kavya.reddy@email.com',
        'order_date' => '2024-01-12',
        'total_amount' => 1599,
        'status' => 'Cancelled',
        'payment_status' => 'Refunded',
        'items' => 1,
        'shipping_address' => '321, Koramangala, Bangalore - 560034'
    ],
    [
        'id' => 'ORD005',
        'customer_name' => 'Riya Gupta',
        'customer_email' => 'riya.gupta@email.com',
        'order_date' => '2024-01-11',
        'total_amount' => 4199,
        'status' => 'Delivered',
        'payment_status' => 'Paid',
        'items' => 5,
        'shipping_address' => '654, Salt Lake City, Kolkata - 700091'
    ]
];

$statuses = ['All', 'Pending', 'Processing', 'In Transit', 'Delivered', 'Cancelled'];
$payment_statuses = ['All', 'Pending', 'Paid', 'Failed', 'Refunded'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management - ManavikFab Admin</title>
    <meta name="description" content="Manage customer orders, track status, and process payments in the ManavikFab admin panel">
    <meta name="keywords" content="admin orders, order management, customer orders, e-commerce admin">
    <meta name="author" content="ManavikFab">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
    /* Reset and layout fixes */
    *, *::before, *::after { box-sizing: border-box; }
    html, body { overflow-x: hidden; }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fa;
        -webkit-font-smoothing:antialiased;
        -moz-osx-font-smoothing:grayscale;
        color: #0f172a;
    }

    /* Sidebar */
      .sidebar {
            background: linear-gradient(135deg, #f8c9d8 0%, #f4b6cc 100%);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            z-index: 1000;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #2d2d2d;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
            display: block;
            align-items: center;
        }
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #2d2d2d;
            box-shadow: none;
            width: 100%;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.12);
            color: #2d2d2d;
        }
    /* Spacing utility used on Index page */
    .section-spacer{ margin-top: 0.5rem; }

    /* Main content area: prevent overflow and set readable base font */
    .main-content {
        margin-left: 240px;
        max-width: calc(100% - 240px);
        background-color: #f8f9fa;
        font-size: 0.96rem;
    }

    /* Navbar and title prominence */
    .navbar { background: white; box-shadow: 0 6px 18px rgba(15,23,42,0.06); padding:.6rem 1rem }
    .navbar .container-fluid h4.mb-0{ font-size:1.5rem; font-weight:800; letter-spacing:-0.2px; margin:0 }

    /* Stats cards */
    .stats-card { background: white; border-radius: 1rem; padding:1.25rem; box-shadow: 0 6px 18px rgba(15,23,42,0.06); transition: transform .25s ease, box-shadow .25s ease }
    .stats-card:hover { transform: translateY(-5px); box-shadow: 0 12px 36px rgba(15,23,42,0.08); }

    /* Table / card containers */
    .table-container { background: white; border-radius: 1rem; padding:1.25rem; box-shadow: 0 6px 18px rgba(15,23,42,0.04); }

    /* Section headings */
    .table-container h5, .stats-card h5, .main-content h5 { font-size:1.05rem; font-weight:700; color:#0f172a; margin-bottom:.75rem }

    /* Tables: ensure they fit and look modern */
    .table-responsive { overflow-x:auto; }
    table { width:100%; font-size:.95rem; border-collapse:collapse; }
    thead.table-dark th { background: #f1f5f9 !important; color:#0f172a !important; font-weight:700; border-bottom:1px solid rgba(15,23,42,0.06) }
    .table tbody tr td, .table thead th { padding:.75rem .9rem; vertical-align:middle }

    /* Status badges: consistent sizing and alignment */
    .status-badge{ padding:6px 12px; border-radius:12px; font-size:.85rem; font-weight:700; display:inline-block }
    .status-pending { background: #fff3cd; color: #856404; }
    .status-processing { background: #cce5ff; color: #004085; }
    .status-transit { background: #d1ecf1; color: #0c5460; }
    .status-delivered { background: #d4edda; color: #155724; }
    .status-cancelled { background: #f8d7da; color: #721c24; }
    .payment-paid { background: #d4edda; color: #155724; }
    .payment-pending { background: #fff3cd; color: #856404; }
    .payment-failed { background: #f8d7da; color: #721c24; }
    .payment-refunded { background: #e2e3e5; color: #383d41; }

    /* Action buttons styling within table */
    .btn-group .btn { border-radius:.5rem; padding:.4rem .6rem; min-width:36px }
    .btn-group .btn i { font-size:1rem }
    .btn-sm { font-size:.85rem }

    /* Reduce large element padding to avoid overflow */
    .table-container .row > [class*="col-"] { padding-left:.5rem; padding-right:.5rem }

    /* Responsive: stack sidebar and content on small screens to avoid horizontal scroll */
    @media (max-width: 991px){
        .sidebar { position: relative; width: 100%; height: auto }
        .main-content { margin-left: 0; max-width: 100%; padding-left: 1rem; padding-right: 1rem }
        .navbar .container-fluid h4.mb-0{ font-size:1.25rem }
    }
    /* Reusable admin dropdown item style: bold, clear typography with icon alignment */
    .admin-dropdown-item{ font-weight:700; font-size:0.95rem; color:#212529; display:flex; align-items:center; gap:0.5rem; padding:0.45rem 0.9rem }
    .dropdown-menu .admin-dropdown-item i{ width:20px; display:inline-flex; align-items:center; justify-content:center; font-size:1rem }
</style>

</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="sidebar p-3">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-dark">
                            <i class="bi bi-heart-fill text-danger me-2"></i>ManavikFab
                        </h4>
                        <small class="text-muted">Admin Panel</small>
                    </div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="index.php">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                    <a class="nav-link active" href="orders.php">
                        <i class="bi bi-cart3 me-2"></i>Orders
                    </a>
                    <a class="nav-link" href="products.php">
                        <i class="bi bi-box me-2"></i>Products
                    </a>
                    <a class="nav-link" href="customers.php">
                        <i class="bi bi-people me-2"></i>Customers
                    </a>
                    <a class="nav-link" href="categories.php">
                        <i class="bi bi-tags me-2"></i>Categories
                    </a>
                    <a class="nav-link" href="inventory.php">
                        <i class="bi bi-boxes me-2"></i>Inventory
                    </a>
                    <a class="nav-link" href="reports.php">
                        <i class="bi bi-graph-up me-2"></i>Reports
                    </a>
                    <a class="nav-link" href="settings.php">
                        <i class="bi bi-gear me-2"></i>Settings
                    </a>
                    <hr>
                    <a class="nav-link" href="logout.php">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 main-content p-4">
            <!-- Orders Management Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 stats-card" style="padding: 1.25rem;">
                <div>
                    <h2 class="mb-1">
                        <i class="bi bi-cart-check text-primary me-2"></i>
                        Orders Management
                    </h2>
                    <p class="text-muted mb-0">Manage orders, track status, and process payments</p>
                </div>
                <div class="dropdown">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-2"></i>Admin
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
                
                <!-- Stats Cards -->
                <div class="row g-4 mb-4 section-spacer">
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-cart-check text-primary" style="font-size: 2rem;"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1"><?php echo count($orders); ?></h5>
                                    <small class="text-muted">Total Orders</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1"><?php echo count(array_filter($orders, function($order) { return $order['status'] == 'Pending'; })); ?></h5>
                                    <small class="text-muted">Pending Orders</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-truck text-info" style="font-size: 2rem;"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1"><?php echo count(array_filter($orders, function($order) { return $order['status'] == 'In Transit'; })); ?></h5>
                                    <small class="text-muted">In Transit</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-currency-rupee text-success" style="font-size: 2rem;"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">₹<?php echo number_format(array_sum(array_column($orders, 'total_amount'))); ?></h5>
                                    <small class="text-muted">Total Revenue</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Filters -->
                <div class="table-container mb-4">
                    <h5 class="mb-3"><i class="bi bi-funnel me-2"></i>Filters</h5>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Order Status</label>
                            <select class="form-select">
                                <option value="">All Statuses</option>
                                <?php foreach($statuses as $status): ?>
                                    <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Payment Status</label>
                            <select class="form-select">
                                <option value="">All Payments</option>
                                <?php foreach($payment_statuses as $payment): ?>
                                    <option value="<?php echo $payment; ?>"><?php echo $payment; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Date Range</label>
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Search</label>
                            <input type="text" class="form-control" placeholder="Order ID, Customer...">
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-custom me-2">
                            <i class="bi bi-search me-2"></i>Apply Filters
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Reset
                        </button>
                    </div>
                </div>
                
                <!-- Orders Table -->
                <div class="table-container">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($orders as $order): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $order['id']; ?></strong>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-1"><?php echo $order['customer_name']; ?></h6>
                                            <small class="text-muted"><?php echo $order['customer_email']; ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><?php echo date('M d, Y', strtotime($order['order_date'])); ?></strong>
                                            <small class="text-muted d-block"><?php echo date('h:i A', strtotime($order['order_date'])); ?></small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark"><?php echo $order['items']; ?> items</span>
                                    </td>
                                    <td>
                                        <strong>₹<?php echo number_format($order['total_amount']); ?></strong>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $order['status'])); ?>">
                                            <?php echo $order['status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-badge payment-<?php echo strtolower($order['payment_status']); ?>">
                                            <?php echo $order['payment_status']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-outline-primary" onclick="viewOrder('<?php echo $order['id']; ?>')" title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-success" onclick="updateStatus('<?php echo $order['id']; ?>')" title="Update Status">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-info" onclick="printInvoice('<?php echo $order['id']; ?>')" title="Print Invoice">
                                                <i class="bi bi-printer"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <small class="text-muted">Showing 1 to <?php echo count($orders); ?> of <?php echo count($orders); ?> orders</small>
                    </div>
                    <nav>
                        <ul class="pagination pagination-sm">
                            <li class="page-item disabled">
                                <a class="page-link" href="#"><i class="bi bi-chevron-left"></i></a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item disabled">
                                <a class="page-link" href="#"><i class="bi bi-chevron-right"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function viewOrder(orderId) {
        // Implement order detail view
        alert('View order details for: ' + orderId);
    }
    
    function updateStatus(orderId) {
        // Implement status update
        alert('Update status for: ' + orderId);
    }
    
    function printInvoice(orderId) {
        // Implement invoice printing
        alert('Print invoice for: ' + orderId);
    }
    
    // Add event listeners for filters
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality can be added here
        console.log('Orders page loaded');
    });
</script>

</body>
</html> 