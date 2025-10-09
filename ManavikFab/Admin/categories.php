<?php
session_start();
include '../connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // header("Location: login.php");
    // exit();
}

// Sample categories data
$categories = [
    [
        'id' => 1,
        'name' => 'Ethnic Wear',
        'description' => 'Traditional Indian ethnic wear including sarees, lehengas, and kurtis',
        'image' => 'images/categories/ethnic-wear.jpg',
        'products_count' => 45,
        'status' => 'Active',
        'created_date' => '2023-01-15',
        'parent_category' => null,
        'slug' => 'ethnic-wear'
    ],
    [
        'id' => 2,
        'name' => 'Western Wear',
        'description' => 'Modern western clothing including dresses, tops, and jeans',
        'image' => 'images/categories/western-wear.jpg',
        'products_count' => 38,
        'status' => 'Active',
        'created_date' => '2023-01-20',
        'parent_category' => null,
        'slug' => 'western-wear'
    ],
    [
        'id' => 3,
        'name' => 'Accessories',
        'description' => 'Fashion accessories including jewelry, bags, and footwear',
        'image' => 'images/categories/accessories.jpg',
        'products_count' => 52,
        'status' => 'Active',
        'created_date' => '2023-02-01',
        'parent_category' => null,
        'slug' => 'accessories'
    ],
    [
        'id' => 4,
        'name' => 'Sarees',
        'description' => 'Traditional Indian sarees in various fabrics and designs',
        'image' => 'images/categories/sarees.jpg',
        'products_count' => 28,
        'status' => 'Active',
        'created_date' => '2023-01-25',
        'parent_category' => 'Ethnic Wear',
        'slug' => 'sarees'
    ],
    [
        'id' => 5,
        'name' => 'Lehengas',
        'description' => 'Bridal and party wear lehengas with intricate designs',
        'image' => 'images/categories/lehengas.jpg',
        'products_count' => 15,
        'status' => 'Active',
        'created_date' => '2023-02-10',
        'parent_category' => 'Ethnic Wear',
        'slug' => 'lehengas'
    ],
    [
        'id' => 6,
        'name' => 'Dresses',
        'description' => 'Casual and party dresses for all occasions',
        'image' => 'images/categories/dresses.jpg',
        'products_count' => 22,
        'status' => 'Active',
        'created_date' => '2023-01-30',
        'parent_category' => 'Western Wear',
        'slug' => 'dresses'
    ],
    [
        'id' => 7,
        'name' => 'Jewelry',
        'description' => 'Traditional and modern jewelry pieces',
        'image' => 'images/categories/jewelry.jpg',
        'products_count' => 35,
        'status' => 'Inactive',
        'created_date' => '2023-02-15',
        'parent_category' => 'Accessories',
        'slug' => 'jewelry'
    ]
];

$statuses = ['All', 'Active', 'Inactive'];
$parent_categories = ['None', 'Ethnic Wear', 'Western Wear', 'Accessories'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Management - ManavikFab Admin</title>
    <meta name="description" content="Manage product categories, organize inventory, and track category performance in the ManavikFab admin panel">
    <meta name="keywords" content="admin categories, category management, product categories, e-commerce admin">
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
        
        .category-card {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: 0 6px 18px rgba(15,23,42,0.06);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            border: none;
        }
        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 36px rgba(15,23,42,0.08);
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
        
        .category-image {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .modal-custom .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }
        
        .modal-custom .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
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
                        <a href="categories.php" class="sidebar-link active">
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
                <!-- PageHeader Card -->
                <div class="page-header-card d-flex justify-content-between align-items-center mb-4" style="background: #fff; border-radius: 1rem; box-shadow: 0 6px 18px rgba(15,23,42,0.06); padding: 1.25rem;">
                    <div>
                        <h2 class="mb-1">
                            <i class="bi bi-tags text-primary me-2"></i>
                            Categories Management
                        </h2>
                        <p class="text-muted mb-0">Organize products into categories for better management</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="bi bi-plus-circle me-2"></i>Add Category
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
                    
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="stats-card p-3 text-center">
                                <i class="bi bi-tags text-primary" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1"><?php echo count($categories); ?></h4>
                                <small class="text-muted">Total Categories</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card p-3 text-center">
                                <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1"><?php echo count(array_filter($categories, function($category) { return $category['status'] == 'Active'; })); ?></h4>
                                <small class="text-muted">Active Categories</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card p-3 text-center">
                                <i class="bi bi-box text-info" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1"><?php echo array_sum(array_column($categories, 'products_count')); ?></h4>
                                <small class="text-muted">Total Products</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card p-3 text-center">
                                <i class="bi bi-diagram-3 text-warning" style="font-size: 2rem;"></i>
                                <h4 class="mt-2 mb-1"><?php echo count(array_filter($categories, function($category) { return $category['parent_category'] !== null; })); ?></h4>
                                <small class="text-muted">Sub Categories</small>
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
                                <label class="form-label">Parent Category</label>
                                <select class="form-select">
                                    <option value="">All Categories</option>
                                    <?php foreach($parent_categories as $parent): ?>
                                        <option value="<?php echo $parent; ?>"><?php echo $parent; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Products Range</label>
                                <select class="form-select">
                                    <option value="">All Ranges</option>
                                    <option value="0-10">0-10 products</option>
                                    <option value="11-25">11-25 products</option>
                                    <option value="26-50">26-50 products</option>
                                    <option value="50+">50+ products</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">Search</label>
                                <input type="text" class="form-control" placeholder="Category name...">
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
                    
                    <!-- Categories Table -->
                    <div class="table-custom">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Parent</th>
                                        <th>Products</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($categories as $category): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="<?php echo $category['image']; ?>" alt="<?php echo $category['name']; ?>" class="category-image me-3">
                                                <div>
                                                    <h6 class="mb-1"><?php echo $category['name']; ?></h6>
                                                    <small class="text-muted">ID: <?php echo $category['id']; ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="text-truncate" style="max-width: 200px;">
                                                <?php echo $category['description']; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($category['parent_category']): ?>
                                                <span class="badge bg-light text-dark"><?php echo $category['parent_category']; ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark"><?php echo $category['products_count']; ?> products</span>
                                        </td>
                                        <td>
                                            <span class="status-badge status-<?php echo strtolower($category['status']); ?>">
                                                <?php echo $category['status']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong><?php echo date('M d, Y', strtotime($category['created_date'])); ?></strong>
                                                <small class="text-muted d-block"><?php echo date('Y', strtotime($category['created_date'])); ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" onclick="viewCategory(<?php echo $category['id']; ?>)" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-success" onclick="editCategory(<?php echo $category['id']; ?>)" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-info" onclick="viewProducts(<?php echo $category['id']; ?>)" title="View Products">
                                                    <i class="bi bi-box"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" onclick="deleteCategory(<?php echo $category['id']; ?>)" title="Delete">
                                                    <i class="bi bi-trash"></i>
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
                            <small class="text-muted">Showing 1 to <?php echo count($categories); ?> of <?php echo count($categories); ?> categories</small>
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
    
    <!-- Add Category Modal -->
    <div class="modal fade modal-custom" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle me-2"></i>Add New Category
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category Name *</label>
                                <input type="text" class="form-control" placeholder="Enter category name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" class="form-control" placeholder="category-slug">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="3" placeholder="Enter category description"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Parent Category</label>
                                <select class="form-select">
                                    <option value="">No Parent</option>
                                    <?php foreach($parent_categories as $parent): ?>
                                        <option value="<?php echo $parent; ?>"><?php echo $parent; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category Image</label>
                            <input type="file" class="form-control" accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-custom">Add Category</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function viewCategory(categoryId) {
            // Implement category detail view
            alert('View category details for: ' + categoryId);
        }
        
        function editCategory(categoryId) {
            // Implement category edit
            alert('Edit category: ' + categoryId);
        }
        
        function viewProducts(categoryId) {
            // Implement products view for category
            alert('View products for category: ' + categoryId);
        }
        
        function deleteCategory(categoryId) {
            // Implement category deletion with confirmation
            if(confirm('Are you sure you want to delete this category?')) {
                alert('Delete category: ' + categoryId);
            }
        }
        
        // Add event listeners for filters
        document.addEventListener('DOMContentLoaded', function() {
            // Filter functionality can be added here
            console.log('Categories page loaded');
        });
    </script>
</body>
</html> 