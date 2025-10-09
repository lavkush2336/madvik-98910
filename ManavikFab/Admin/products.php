<?php
session_start();
include '../connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // header("Location: login.php");
    // exit();
}

// Sample products data
$products = [
    [
        'id' => 1,
        'name' => 'Embroidered Silk Saree',
        'category' => 'Sarees',
        'price' => 2499,
        'original_price' => 3999,
        'stock' => 25,
        'status' => 'Active',
        'image' => '../images/product1.jpg'
    ],
    [
        'id' => 2,
        'name' => 'Designer Lehenga Set',
        'category' => 'Lehengas',
        'price' => 5999,
        'original_price' => 8999,
        'stock' => 15,
        'status' => 'Active',
        'image' => '../images/product2.jpg'
    ],
    [
        'id' => 3,
        'name' => 'Cotton Kurti with Palazzo',
        'category' => 'Ethnic Wear',
        'price' => 1299,
        'original_price' => 1999,
        'stock' => 40,
        'status' => 'Active',
        'image' => '../images/product3.jpg'
    ],
    [
        'id' => 4,
        'name' => 'Western Dress Collection',
        'category' => 'Western Wear',
        'price' => 1899,
        'original_price' => 2499,
        'stock' => 30,
        'status' => 'Active',
        'image' => '../images/product4.jpg'
    ],
    [
        'id' => 5,
        'name' => 'Bridal Lehenga Set',
        'category' => 'Lehengas',
        'price' => 8999,
        'original_price' => 12999,
        'stock' => 8,
        'status' => 'Active',
        'image' => '../images/product5.jpg'
    ],
    [
        'id' => 6,
        'name' => 'Silk Anarkali Suit',
        'category' => 'Ethnic Wear',
        'price' => 3499,
        'original_price' => 4999,
        'stock' => 20,
        'status' => 'Inactive',
        'image' => '../images/product6.jpg'
    ]
];

$categories = ['Ethnic Wear', 'Western Wear', 'Sarees', 'Lehengas', 'Accessories'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Management - ManavikFab Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        html, body { overflow-x: hidden; }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #0f172a;
        }
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
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: #2d2d2d;
        }
        .main-content {
            margin-left: 240px;
            background-color: #f8f9fa;
            font-size: 1rem;
        }
        .navbar {
            background: white;
            box-shadow: 0 6px 18px rgba(15,23,42,0.06);
            padding: .8rem 1.2rem;
        }
        .navbar .container-fluid h4.mb-0 {
            font-size: 2rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin: 0;
            color: #0f172a;
        }
        .table-container {
            background: white;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 6px 18px rgba(15,23,42,0.04);
        }
        .table-container h5 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1rem;
        }
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.5rem;
        }
        .form-label {
            font-size: 1rem;
            font-weight: 600;
            color: #0f172a;
        }
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
        table {
            width: 100%;
            font-size: 0.98rem;
            border-collapse: collapse;
        }
        thead th {
            font-weight: 700;
            font-size: 1rem;
            background: #f1f5f9;
            color: #0f172a;
            border-bottom: 1px solid #e5e7eb;
        }
        .table tbody tr td, .table thead th {
            padding: .75rem .9rem;
            vertical-align: middle;
        }
        .badge {
            padding: 6px 14px;
            border-radius: 12px;
            font-size: .92rem;
            font-weight: 700;
            display: inline-block;
            letter-spacing: 0.01em;
        }
        .badge.bg-success, .badge.bg-warning, .badge.bg-danger, .badge.bg-secondary, .badge.bg-light {
            color: #212529;
        }
        .btn-group .btn {
            border-radius: .5rem;
            padding: .4rem .6rem;
            min-width: 36px;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }
        .btn-group .btn i {
            font-size: 1.1rem;
        }
        .btn-group .btn[title]:hover::after {
            content: attr(title);
            position: absolute;
            background: #212529;
            color: #fff;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: .85rem;
            left: 50%;
            top: 120%;
            transform: translateX(-50%);
            white-space: nowrap;
            z-index: 10;
        }
        .btn-primary {
            font-weight: 700;
            font-size: 1rem;
            border-radius: .6rem;
            padding: .5rem 1.2rem;
        }
        .table-container .row.g-3 > [class*="col-"] {
            padding-left: .5rem;
            padding-right: .5rem;
        }
        .table-container .row.g-3 {
            margin-bottom: 0;
            gap: 0.5rem;
        }
        @media (max-width: 991px) {
            .sidebar { position: relative; width: 100%; height: auto; }
            .main-content { margin-left: 0; max-width: 100%; padding-left: 1rem; padding-right: 1rem; }
            .navbar .container-fluid h4.mb-0 { font-size: 1.25rem; }
        }
        /* Reusable admin dropdown item style: bold, clear typography with icon alignment */
        .admin-dropdown-item{ font-weight:700; font-size:0.95rem; color:#212529; display:flex; align-items:center; gap:0.5rem; padding:0.45rem 0.9rem }
        .dropdown-menu .admin-dropdown-item i{ width:20px; display:inline-flex; align-items:center; justify-content:center; font-size:1rem }
        }
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
                        <a class="nav-link" href="orders.php">
                            <i class="bi bi-cart3 me-2"></i>Orders
                        </a>
                        <a class="nav-link active" href="products.php">
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
                <!-- Top Navigation Bar -->
                <nav class="navbar" style="background: #fff; box-shadow: 0 6px 18px rgba(15,23,42,0.06); padding: .6rem 1rem; min-height:64px; border-radius: 1rem; margin-bottom: 1.5rem;">
                    <div class="container-fluid d-flex justify-content-between align-items-center p-0">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-box text-primary me-2" style="font-size:2rem;"></i>
                            <div class="d-flex flex-column justify-content-center">
                                <span class="text-primary me-2;">Products Management</span>
                                <span class="text-muted" style="font-size:1rem; margin-top:2px;">Manage products, categories, and inventory</span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal" style="font-weight:600; font-size:1rem; box-shadow:0 2px 8px rgba(102,126,234,0.08);">
                                <i class="bi bi-plus-circle me-2"></i>Add Product
                            </button>
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
                    </div>
                </nav>

                <div class="p-4">
                    <!-- Filters -->
                    <div class="table-container mb-4">
                        <div class="row g-3">
                            <div class="col-md-3 d-flex flex-column justify-content-end">
                                <label class="form-label">Category</label>
                                <select class="form-select">
                                    <option value="">All Categories</option>
                                    <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select class="form-select">
                                    <option value="">All Status</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Stock</label>
                                <select class="form-select">
                                    <option value="">All Stock</option>
                                    <option value="in-stock">In Stock</option>
                                    <option value="low-stock">Low Stock</option>
                                    <option value="out-of-stock">Out of Stock</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Search</label>
                                <input type="text" class="form-control" placeholder="Search products...">
                            </div>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="table-container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0">All Products (<?php echo count($products); ?>)</h5>
                            <div class="btn-group">
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-grid-3x3-gap"></i>
                                </button>
                                <button class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-list"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($products as $product): ?>
                                    <tr>
                                        <td>
                                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-image">
                                        </td>
                                        <td>
                                            <div>
                                                <h6 class="mb-1"><?php echo $product['name']; ?></h6>
                                                <small class="text-muted">ID: <?php echo $product['id']; ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark"><?php echo $product['category']; ?></span>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="fw-bold">₹<?php echo number_format($product['price']); ?></span>
                                                <small class="text-muted text-decoration-line-through d-block">₹<?php echo number_format($product['original_price']); ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php 
                                                echo $product['stock'] > 20 ? 'success' : 
                                                    ($product['stock'] > 10 ? 'warning' : 'danger'); 
                                            ?>">
                                                <?php echo $product['stock']; ?> units
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo $product['status'] == 'Active' ? 'success' : 'secondary'; ?>">
                                                <?php echo $product['status']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="editProduct(<?php echo $product['id']; ?>)" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" onclick="viewProduct(<?php echo $product['id']; ?>)" title="View">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteProduct(<?php echo $product['id']; ?>)" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <nav aria-label="Products pagination" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Product Name *</label>
                                <input type="text" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category *</label>
                                <select class="form-select" required>
                                    <option value="">Select Category</option>
                                    <?php foreach($categories as $category): ?>
                                    <option value="<?php echo $category; ?>"><?php echo $category; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price (₹) *</label>
                                <input type="number" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Original Price (₹)</label>
                                <input type="number" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock Quantity *</label>
                                <input type="number" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Images</label>
                            <input type="file" class="form-control" multiple accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Add Product</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function editProduct(productId) {
            // Edit product functionality
            console.log('Editing product:', productId);
            alert('Edit product functionality would be implemented here');
        }

        function viewProduct(productId) {
            // View product functionality
            console.log('Viewing product:', productId);
            alert('View product functionality would be implemented here');
        }

        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                // Delete product functionality
                console.log('Deleting product:', productId);
                alert('Product deleted successfully!');
            }
        }
    </script>
</body>
</html> 