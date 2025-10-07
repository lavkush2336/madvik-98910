<?php
session_start();
include '../connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // header("Location: login.php");
    // exit();
}

// Sample customers data
$customers = [
    [
        'id' => 1,
        'name' => 'Priya Sharma',
        'email' => 'priya.sharma@email.com',
        'phone' => '+91 98765 43210',
        'join_date' => '2023-12-01',
        'total_orders' => 8,
        'total_spent' => 18999,
        'last_order' => '2024-01-15',
        'status' => 'Active',
        'city' => 'New Delhi',
        'state' => 'Delhi'
    ],
    [
        'id' => 2,
        'name' => 'Anjali Patel',
        'email' => 'anjali.patel@email.com',
        'phone' => '+91 87654 32109',
        'join_date' => '2023-11-15',
        'total_orders' => 5,
        'total_spent' => 12499,
        'last_order' => '2024-01-14',
        'status' => 'Active',
        'city' => 'Gurgaon',
        'state' => 'Haryana'
    ],
    [
        'id' => 3,
        'name' => 'Meera Singh',
        'email' => 'meera.singh@email.com',
        'phone' => '+91 76543 21098',
        'join_date' => '2023-10-20',
        'total_orders' => 12,
        'total_spent' => 28999,
        'last_order' => '2024-01-13',
        'status' => 'Active',
        'city' => 'Mumbai',
        'state' => 'Maharashtra'
    ],
    [
        'id' => 4,
        'name' => 'Kavya Reddy',
        'email' => 'kavya.reddy@email.com',
        'phone' => '+91 65432 10987',
        'join_date' => '2023-09-10',
        'total_orders' => 3,
        'total_spent' => 5999,
        'last_order' => '2024-01-12',
        'status' => 'Inactive',
        'city' => 'Bangalore',
        'state' => 'Karnataka'
    ],
    [
        'id' => 5,
        'name' => 'Riya Gupta',
        'email' => 'riya.gupta@email.com',
        'phone' => '+91 54321 09876',
        'join_date' => '2023-08-25',
        'total_orders' => 15,
        'total_spent' => 35999,
        'last_order' => '2024-01-11',
        'status' => 'Active',
        'city' => 'Kolkata',
        'state' => 'West Bengal'
    ],
    [
        'id' => 6,
        'name' => 'Zara Khan',
        'email' => 'zara.khan@email.com',
        'phone' => '+91 43210 98765',
        'join_date' => '2024-01-05',
        'total_orders' => 1,
        'total_spent' => 2499,
        'last_order' => '2024-01-10',
        'status' => 'Active',
        'city' => 'Hyderabad',
        'state' => 'Telangana'
    ]
];

$statuses = ['All', 'Active', 'Inactive'];
$cities = ['All', 'New Delhi', 'Gurgaon', 'Mumbai', 'Bangalore', 'Kolkata', 'Hyderabad'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers Management - ManavikFab Admin</title>
    <meta name="description" content="Manage customer information, track orders, and analyze customer behavior in the ManavikFab admin panel">
    <meta name="keywords" content="admin customers, customer management, customer analytics, e-commerce admin">
    <meta name="author" content="ManavikFab">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
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
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-left: 240px;
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
        
        .customer-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .customer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-active { background: #d4edda; color: #155724; }
        .status-inactive { background: #f8d7da; color: #721c24; }
        
        .filter-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
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
        
        .stats-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-3px);
        }
        
        .table-custom {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .table-custom th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px;
        }
        
        .table-custom td {
            padding: 15px;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .table-custom tbody tr:hover {
            background: #f8f9fa;
        }
        
        .customer-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
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
                        <a href="customers.php" class="sidebar-link active">
                            <i class="bi bi-people"></i> Customers
                        </a>
                        <a href="categories.php" class="sidebar-link">
                            <i class="bi bi-tags"></i> Categories
                        </a>
                        <a href="inventory.php" class="sidebar-link">
                            <i class="bi bi-boxes"></i> Inventory
                        </a>
                        <a href="reports.php" class="sidebar-link">
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
                                <i class="bi bi-people text-primary me-2"></i>
                                Customers Management
                            </h2>
                            <p class="text-muted mb-0">Manage customer information and track their behavior</p>
                        </div>
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
                    
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="stats-card p-3 text-center">
                                <i class="bi bi-people text-primary" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1"><?php echo count($customers); ?></h4>
                                <small class="text-muted">Total Customers</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card p-3 text-center">
                                <i class="bi bi-person-check text-success" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1"><?php echo count(array_filter($customers, function($customer) { return $customer['status'] == 'Active'; })); ?></h4>
                                <small class="text-muted">Active Customers</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card p-3 text-center">
                                <i class="bi bi-currency-rupee text-info" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1">₹<?php echo number_format(array_sum(array_column($customers, 'total_spent'))); ?></h4>
                                <small class="text-muted">Total Revenue</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card p-3 text-center">
                                <i class="bi bi-cart-check text-warning" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1"><?php echo array_sum(array_column($customers, 'total_orders')); ?></h4>
                                <small class="text-muted">Total Orders</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filters -->
                    <div class="filter-card p-4 mb-4">
                        <h5 class="mb-3"><i class="bi bi-funnel me-2"></i>Filters</h5>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select">
                                    <option value="">All Status</option>
                                    <?php foreach($statuses as $status): ?>
                                        <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">City</label>
                                <select class="form-select">
                                    <option value="">All Cities</option>
                                    <?php foreach($cities as $city): ?>
                                        <option value="<?php echo $city; ?>"><?php echo $city; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Join Date</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Search</label>
                                <input type="text" class="form-control" placeholder="Name, Email, Phone...">
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
                    
                    <!-- Customers Table -->
                    <div class="table-custom">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Customer</th>
                                        <th>Contact</th>
                                        <th>Location</th>
                                        <th>Join Date</th>
                                        <th>Orders</th>
                                        <th>Total Spent</th>
                                        <th>Last Order</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($customers as $customer): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="customer-avatar me-3">
                                                    <?php echo strtoupper(substr($customer['name'], 0, 1)); ?>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1"><?php echo $customer['name']; ?></h6>
                                                    <small class="text-muted">ID: <?php echo $customer['id']; ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="mb-1"><?php echo $customer['email']; ?></div>
                                                <small class="text-muted"><?php echo $customer['phone']; ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="mb-1"><?php echo $customer['city']; ?></div>
                                                <small class="text-muted"><?php echo $customer['state']; ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?php echo date('M d, Y', strtotime($customer['join_date'])); ?></strong>
                                                <small class="text-muted d-block"><?php echo date('Y', strtotime($customer['join_date'])); ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark"><?php echo $customer['total_orders']; ?> orders</span>
                                        </td>
                                        <td>
                                            <strong>₹<?php echo number_format($customer['total_spent']); ?></strong>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?php echo date('M d', strtotime($customer['last_order'])); ?></strong>
                                                <small class="text-muted d-block"><?php echo date('Y', strtotime($customer['last_order'])); ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo strtolower($customer['status']); ?>">
                                                <?php echo $customer['status']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewCustomer(<?php echo $customer['id']; ?>)" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" onclick="viewOrders(<?php echo $customer['id']; ?>)" title="View Orders">
                                                    <i class="bi bi-cart-check"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" onclick="editCustomer(<?php echo $customer['id']; ?>)" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" onclick="sendEmail(<?php echo $customer['id']; ?>)" title="Send Email">
                                                    <i class="bi bi-envelope"></i>
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
                            <small class="text-muted">Showing 1 to <?php echo count($customers); ?> of <?php echo count($customers); ?> customers</small>
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
        function viewCustomer(customerId) {
            // Implement customer detail view
            alert('View customer details for: ' + customerId);
        }
        
        function viewOrders(customerId) {
            // Implement customer orders view
            alert('View orders for customer: ' + customerId);
        }
        
        function editCustomer(customerId) {
            // Implement customer edit
            alert('Edit customer: ' + customerId);
        }
        
        function sendEmail(customerId) {
            // Implement email functionality
            alert('Send email to customer: ' + customerId);
        }
        
        // Add event listeners for filters
        document.addEventListener('DOMContentLoaded', function() {
            // Filter functionality can be added here
            console.log('Customers page loaded');
        });
    </script>
</body>
</html> 