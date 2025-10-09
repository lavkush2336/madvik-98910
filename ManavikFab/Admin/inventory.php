<?php
session_start();
include '../connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // header("Location: login.php");
    // exit();
}

// Sample inventory data
$inventory_items = [
    [
        'id' => 1,
        'product_name' => 'Silk Saree - Traditional Red',
        'sku' => 'SS-RED-001',
        'category' => 'Sarees',
        'current_stock' => 25,
        'min_stock' => 10,
        'max_stock' => 100,
        'unit_cost' => 1200,
        'total_value' => 30000,
        'last_updated' => '2024-01-15',
        'status' => 'In Stock',
        'supplier' => 'Silk Weavers Ltd',
        'location' => 'Warehouse A'
    ],
    [
        'id' => 2,
        'product_name' => 'Bridal Lehenga - Gold Embroidered',
        'sku' => 'BL-GOLD-002',
        'category' => 'Lehengas',
        'current_stock' => 8,
        'min_stock' => 15,
        'max_stock' => 50,
        'unit_cost' => 3500,
        'total_value' => 28000,
        'last_updated' => '2024-01-14',
        'status' => 'Low Stock',
        'supplier' => 'Royal Garments',
        'location' => 'Warehouse B'
    ],
    [
        'id' => 3,
        'product_name' => 'Cotton Kurti - Blue Floral',
        'sku' => 'CK-BLUE-003',
        'category' => 'Kurtis',
        'current_stock' => 45,
        'min_stock' => 20,
        'max_stock' => 80,
        'unit_cost' => 450,
        'total_value' => 20250,
        'last_updated' => '2024-01-13',
        'status' => 'In Stock',
        'supplier' => 'Cotton Crafts',
        'location' => 'Warehouse A'
    ],
    [
        'id' => 4,
        'product_name' => 'Party Dress - Black Sequined',
        'sku' => 'PD-BLACK-004',
        'category' => 'Dresses',
        'current_stock' => 0,
        'min_stock' => 5,
        'max_stock' => 30,
        'unit_cost' => 1800,
        'total_value' => 0,
        'last_updated' => '2024-01-12',
        'status' => 'Out of Stock',
        'supplier' => 'Fashion Forward',
        'location' => 'Warehouse C'
    ],
    [
        'id' => 5,
        'product_name' => 'Silver Jewelry Set',
        'sku' => 'SJS-SILVER-005',
        'category' => 'Jewelry',
        'current_stock' => 12,
        'min_stock' => 8,
        'max_stock' => 40,
        'unit_cost' => 800,
        'total_value' => 9600,
        'last_updated' => '2024-01-11',
        'status' => 'Low Stock',
        'supplier' => 'Silver Artisans',
        'location' => 'Warehouse B'
    ],
    [
        'id' => 6,
        'product_name' => 'Designer Handbag - Brown Leather',
        'sku' => 'DH-BROWN-006',
        'category' => 'Accessories',
        'current_stock' => 18,
        'min_stock' => 10,
        'max_stock' => 60,
        'unit_cost' => 1200,
        'total_value' => 21600,
        'last_updated' => '2024-01-10',
        'status' => 'In Stock',
        'supplier' => 'Leather Crafts',
        'location' => 'Warehouse A'
    ]
];

$categories = ['All', 'Sarees', 'Lehengas', 'Kurtis', 'Dresses', 'Jewelry', 'Accessories'];
$statuses = ['All', 'In Stock', 'Low Stock', 'Out of Stock'];
$locations = ['All', 'Warehouse A', 'Warehouse B', 'Warehouse C'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - ManavikFab Admin</title>
    <meta name="description" content="Manage inventory levels, track stock movements, and monitor low stock alerts in the ManavikFab admin panel">
    <meta name="keywords" content="admin inventory, stock management, inventory tracking, e-commerce admin">
    <meta name="author" content="ManavikFab">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
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
            max-width: calc(100vw - 240px);
            background-color: #f8f9fa;
            font-size: 0.96rem;
            overflow-x: hidden;
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
        
        .inventory-card {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: 0 6px 18px rgba(15,23,42,0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            border: none;
        }
        .inventory-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 36px rgba(15,23,42,0.08);
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .status-in-stock { background: #d4edda; color: #155724; }
        .status-low-stock { background: #fff3cd; color: #856404; }
        .status-out-of-stock { background: #f8d7da; color: #721c24; }
        
        .filter-card {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: 0 6px 18px rgba(15,23,42,0.04);
            border: none;
        }
        
        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(102,126,234,0.08);
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.18);
            color: #fff;
        }
        
        .stats-card {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: 0 6px 18px rgba(15,23,42,0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            border: none;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 36px rgba(15,23,42,0.08);
        }
        
        .table-custom {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .table-custom th {
            background: #f1f5f9;
            color: #0f172a;
            font-weight: 700;
            border-bottom: 1px solid rgba(15,23,42,0.06);
            border: none;
            padding: .75rem .9rem;
            vertical-align: middle;
        }
        
        .table-custom td {
            padding: 15px;
            border-bottom: 1px solid #f8f9fa;
        }
        
        .table-custom tbody tr:hover {
            background: #f8f9fa;
        }
        
        .stock-bar {
            height: 8px;
            border-radius: 4px;
            background: #e9ecef;
            overflow: hidden;
        }
        
        .stock-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s ease;
        }
        
        .stock-high { background: #28a745; }
        .stock-medium { background: #ffc107; }
        .stock-low { background: #dc3545; }
        
        .alert-card {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            color: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
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
                        <a href="inventory.php" class="sidebar-link active">
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
                <!-- PageHeader Card -->
                <div class="page-header-card d-flex justify-content-between align-items-center mb-4" style="background: #fff; border-radius: 1rem; box-shadow: 0 6px 18px rgba(15,23,42,0.06); padding: 1.25rem;">
                    <div>
                        <h2 class="mb-1">
                            <i class="bi bi-boxes text-primary me-2"></i>
                            Inventory Management
                        </h2>
                        <p class="text-muted mb-0">Track stock levels and manage inventory efficiently</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addStockModal">
                            <i class="bi bi-plus-circle me-2"></i>Add Stock
                        </button>
                        <button class="btn btn-outline-warning">
                            <i class="bi bi-download me-2"></i>Export
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
                    
                    <!-- Low Stock Alerts -->
                    <?php 
                    $low_stock_items = array_filter($inventory_items, function($item) {
                        return $item['status'] == 'Low Stock' || $item['status'] == 'Out of Stock';
                    });
                    if(count($low_stock_items) > 0): 
                    ?>
                    <div class="alert-card">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-exclamation-triangle me-3" style="font-size: 2rem;"></i>
                            <div>
                                <h5 class="mb-1">Low Stock Alert!</h5>
                                <p class="mb-0"><?php echo count($low_stock_items); ?> items need immediate attention</p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="stats-card p-3 text-center">
                                <i class="bi bi-boxes text-primary" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1"><?php echo count($inventory_items); ?></h4>
                                <small class="text-muted">Total Items</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card p-3 text-center">
                                <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1"><?php echo count(array_filter($inventory_items, function($item) { return $item['status'] == 'In Stock'; })); ?></h4>
                                <small class="text-muted">In Stock</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card p-3 text-center">
                                <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1"><?php echo count(array_filter($inventory_items, function($item) { return $item['status'] == 'Low Stock'; })); ?></h4>
                                <small class="text-muted">Low Stock</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card p-3 text-center">
                                <i class="bi bi-currency-rupee text-info" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1">₹<?php echo number_format(array_sum(array_column($inventory_items, 'total_value'))); ?></h4>
                                <small class="text-muted">Total Value</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Filters -->
                    <div class="filter-card p-4 mb-4">
                        <h5 class="mb-3"><i class="bi bi-funnel me-2"></i>Filters</h5>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Category</label>
                                <select class="form-select">
                                    <option value="">All Categories</option>
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
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
                                <label class="form-label">Location</label>
                                <select class="form-select">
                                    <option value="">All Locations</option>
                                    <?php foreach($locations as $location): ?>
                                        <option value="<?php echo $location; ?>"><?php echo $location; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Search</label>
                                <input type="text" class="form-control" placeholder="Product name, SKU...">
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
                    
                    <!-- Inventory Table -->
                    <div class="table-custom">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>SKU</th>
                                        <th>Category</th>
                                        <th>Stock Level</th>
                                        <th>Status</th>
                                        <th>Unit Cost</th>
                                        <th>Total Value</th>
                                        <th>Location</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($inventory_items as $item): ?>
                                    <tr>
                                        <td>
                                            <div>
                                                <h6 class="mb-1"><?php echo $item['product_name']; ?></h6>
                                                <small class="text-muted">ID: <?php echo $item['id']; ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <code><?php echo $item['sku']; ?></code>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark"><?php echo $item['category']; ?></span>
                                        </td>
                                        <td>
                                            <div class="mb-2">
                                                <div class="d-flex justify-content-between mb-1">
                                                    <small><?php echo $item['current_stock']; ?> / <?php echo $item['max_stock']; ?></small>
                                                    <small><?php echo round(($item['current_stock'] / $item['max_stock']) * 100); ?>%</small>
                                                </div>
                                                <div class="stock-bar">
                                                    <?php 
                                                    $percentage = ($item['current_stock'] / $item['max_stock']) * 100;
                                                    $stock_class = $percentage > 50 ? 'stock-high' : ($percentage > 20 ? 'stock-medium' : 'stock-low');
                                                    ?>
                                                    <div class="stock-fill <?php echo $stock_class; ?>" style="width: <?php echo $percentage; ?>%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $item['status'])); ?>">
                                                <?php echo $item['status']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <strong>₹<?php echo number_format($item['unit_cost']); ?></strong>
                                        </td>
                                        <td>
                                            <strong>₹<?php echo number_format($item['total_value']); ?></strong>
                                        </td>
                                        <td>
                                            <small><?php echo $item['location']; ?></small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewItem(<?php echo $item['id']; ?>)" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" onclick="addStock(<?php echo $item['id']; ?>)" title="Add Stock">
                                                    <i class="bi bi-plus-circle"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-warning" onclick="adjustStock(<?php echo $item['id']; ?>)" title="Adjust Stock">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" onclick="viewHistory(<?php echo $item['id']; ?>)" title="View History">
                                                    <i class="bi bi-clock-history"></i>
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
                            <small class="text-muted">Showing 1 to <?php echo count($inventory_items); ?> of <?php echo count($inventory_items); ?> items</small>
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
    
    <!-- Add Stock Modal -->
    <div class="modal fade" id="addStockModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>Add Stock
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Product *</label>
                                <select class="form-select" required>
                                    <option value="">Select Product</option>
                                    <?php foreach($inventory_items as $item): ?>
                                        <option value="<?php echo $item['id']; ?>"><?php echo $item['product_name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Quantity *</label>
                                <input type="number" class="form-control" placeholder="Enter quantity" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Unit Cost</label>
                                <input type="number" class="form-control" placeholder="Enter unit cost">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Supplier</label>
                                <input type="text" class="form-control" placeholder="Enter supplier name">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea class="form-control" rows="3" placeholder="Add any notes..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-custom">Add Stock</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function viewItem(itemId) {
            // Implement item detail view
            alert('View inventory details for: ' + itemId);
        }
        
        function addStock(itemId) {
            // Implement add stock functionality
            alert('Add stock for item: ' + itemId);
        }
        
        function adjustStock(itemId) {
            // Implement stock adjustment
            alert('Adjust stock for item: ' + itemId);
        }
        
        function viewHistory(itemId) {
            // Implement stock history view
            alert('View stock history for item: ' + itemId);
        }
        
        // Add event listeners for filters
        document.addEventListener('DOMContentLoaded', function() {
            // Filter functionality can be added here
            console.log('Inventory page loaded');
        });
    </script>
</body>
</html> 