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
    ['id' => 1, 'name' => 'Ethnic Wear', 'description' => 'Traditional Indian ethnic wear including sarees, lehengas, and kurtis', 'image' => 'images/categories/ethnic-wear.jpg', 'products_count' => 45, 'status' => 'Active', 'created_date' => '2023-01-15', 'parent_category' => null, 'slug' => 'ethnic-wear'],
    ['id' => 2, 'name' => 'Western Wear', 'description' => 'Modern western clothing including dresses, tops, and jeans', 'image' => 'images/categories/western-wear.jpg', 'products_count' => 38, 'status' => 'Active', 'created_date' => '2023-01-20', 'parent_category' => null, 'slug' => 'western-wear'],
    ['id' => 3, 'name' => 'Accessories', 'description' => 'Fashion accessories including jewelry, bags, and footwear', 'image' => 'images/categories/accessories.jpg', 'products_count' => 52, 'status' => 'Active', 'created_date' => '2023-02-01', 'parent_category' => null, 'slug' => 'accessories'],
    ['id' => 4, 'name' => 'Sarees', 'description' => 'Traditional Indian sarees in various fabrics and designs', 'image' => 'images/categories/sarees.jpg', 'products_count' => 28, 'status' => 'Active', 'created_date' => '2023-01-25', 'parent_category' => 'Ethnic Wear', 'slug' => 'sarees'],
    ['id' => 5, 'name' => 'Lehengas', 'description' => 'Bridal and party wear lehengas with intricate designs', 'image' => 'images/categories/lehengas.jpg', 'products_count' => 15, 'status' => 'Active', 'created_date' => '2023-02-10', 'parent_category' => 'Ethnic Wear', 'slug' => 'lehengas'],
    ['id' => 6, 'name' => 'Dresses', 'description' => 'Casual and party dresses for all occasions', 'image' => 'images/categories/dresses.jpg', 'products_count' => 22, 'status' => 'Active', 'created_date' => '2023-01-30', 'parent_category' => 'Western Wear', 'slug' => 'dresses'],
    ['id' => 7, 'name' => 'Jewelry', 'description' => 'Traditional and modern jewelry pieces', 'image' => 'images/categories/jewelry.jpg', 'products_count' => 35, 'status' => 'Inactive', 'created_date' => '2023-02-15', 'parent_category' => 'Accessories', 'slug' => 'jewelry']
];

$statuses = ['All', 'Active', 'Inactive'];
$parent_categories = ['None', 'Ethnic Wear', 'Western Wear', 'Accessories'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categories Management - ManavikFab</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        *, *::before, *::after { box-sizing: border-box; }
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
        }
        .sidebar .nav-link {
            color: #2d2d2d;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin: 0.25rem 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link.active, .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #2d2d2d;
        }
        .main-content {
            margin-left: 240px;
        }
        .navbar { background: white; box-shadow: 0 6px 18px rgba(15,23,42,0.06); padding:.6rem 1rem }
        .navbar h4.mb-0{ font-size:1.5rem; font-weight:800; }
        .stats-card {
            background: white;
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: 0 6px 18px rgba(15,23,42,0.06);
        }
        .table-container { background: white; border-radius: 1rem; padding: 1.25rem; box-shadow: 0 6px 18px rgba(15,23,42,0.04); }
        .category-image {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            object-fit: cover;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar p-3" id="sidebar">
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-dark"><i class="bi bi-heart-fill text-danger me-2"></i>ManavikFab</h4>
                    <small class="text-muted">Admin Panel</small>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link" href="index.php"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                    <a class="nav-link" href="orders.php"><i class="bi bi-cart3 me-2"></i>Orders</a>
                    <a class="nav-link" href="products.php"><i class="bi bi-box me-2"></i>Products</a>
                    <a class="nav-link" href="customers.php"><i class="bi bi-people me-2"></i>Customers</a>
                    <a class="nav-link active" href="categories.php"><i class="bi bi-tags me-2"></i>Categories</a>
                    <a class="nav-link" href="inventory.php"><i class="bi bi-boxes me-2"></i>Inventory</a>
                    <a class="nav-link" href="reports.php"><i class="bi bi-graph-up me-2"></i>Reports</a>
                    <a class="nav-link" href="settings.php"><i class="bi bi-gear me-2"></i>Settings</a>
                    <hr>
                    <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Logout</a>
                </nav>
            </div>
            
            <div class="col-md-9 col-lg-10 main-content p-4">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <button class="btn btn-outline-secondary d-lg-none me-3" type="button" id="sidebarToggle"><i class="bi bi-list"></i></button>
                        <h4 class="mb-0">Categories Management</h4>
                        <div class="d-flex align-items-center ms-auto">
                             <button class="btn btn-success me-2">
                                <i class="bi bi-tags me-2"></i>Add Brand
                            </button>
                            <button class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                                <i class="bi bi-plus-circle me-2"></i>Add Category
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"><i class="bi bi-person-circle me-2"></i>Admin</button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
                                    <li><a class="dropdown-item" href="#">Settings</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="p-4">
                    <div class="table-container">
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
                                                    <h6 class="mb-0 fw-bold"><?php echo $category['name']; ?></h6>
                                                    <small class="text-muted">ID: <?php echo $category['id']; ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><div class="text-truncate" style="max-width: 250px;"><?php echo $category['description']; ?></div></td>
                                        <td>
                                            <?php if($category['parent_category']): ?>
                                                <span class="badge bg-light text-dark"><?php echo $category['parent_category']; ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">—</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $category['products_count']; ?></td>
                                        <td><span class="badge bg-<?php echo $category['status'] == 'Active' ? 'success' : 'secondary'; ?>"><?php echo $category['status']; ?></span></td>
                                        <td><?php echo date('M d, Y', strtotime($category['created_date'])); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" title="View"><i class="bi bi-eye"></i></button>
                                                <button class="btn btn-sm btn-outline-success" title="Edit"><i class="bi bi-pencil"></i></button>
                                                <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                                            </div>
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
    
    <div class="modal fade" id="addCategoryModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category Name *</label>
                                <input type="text" id="categoryName" class="form-control" placeholder="Enter category name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Slug</label>
                                <input type="text" id="categorySlug" class="form-control" placeholder="e.g., ethnic-wear">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" id="categoryDescription" rows="3" placeholder="Enter a brief category description"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Parent Category</label>
                                <select class="form-select" id="parentCategory">
                                    <option value="">No Parent</option>
                                    <?php foreach(array_filter($parent_categories, function($p) { return $p !== 'None'; }) as $parent): ?>
                                        <option value="<?php echo $parent; ?>"><?php echo $parent; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="categoryStatus">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveCategoryBtn">Add Category</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- NEW SCRIPT TO MAKE THE MODAL FORM WORK ---

            const saveButton = document.getElementById('saveCategoryBtn');
            const addCategoryModal = new bootstrap.Modal(document.getElementById('addCategoryModal'));
            const categoryForm = document.getElementById('addCategoryForm');
            const tableBody = document.querySelector('.table tbody');

            saveButton.addEventListener('click', function() {
                // 1. Get data from the form fields
                const categoryName = document.getElementById('categoryName').value;
                const description = document.getElementById('categoryDescription').value;
                const parentCategory = document.getElementById('parentCategory').value;
                const status = document.getElementById('categoryStatus').value;
                
                // Simple validation
                if (!categoryName) {
                    alert('Category Name is required.');
                    return;
                }

                // 2. Create the HTML for the new table row
                const newRow = `
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="images/categories/default.jpg" alt="${categoryName}" class="category-image me-3">
                                <div>
                                    <h6 class="mb-0 fw-bold">${categoryName}</h6>
                                    <small class="text-muted">ID: New</small>
                                </div>
                            </div>
                        </td>
                        <td><div class="text-truncate" style="max-width: 250px;">${description}</div></td>
                        <td>${parentCategory ? `<span class="badge bg-light text-dark">${parentCategory}</span>` : '<span class="text-muted">—</span>'}</td>
                        <td>0</td>
                        <td><span class="badge bg-${status === 'Active' ? 'success' : 'secondary'}">${status}</span></td>
                        <td>${new Date().toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' })}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-primary" title="View"><i class="bi bi-eye"></i></button>
                                <button class="btn btn-sm btn-outline-success" title="Edit"><i class="bi bi-pencil"></i></button>
                                <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                `;

                // 3. Insert the new row at the top of the table
                tableBody.insertAdjacentHTML('afterbegin', newRow);

                // 4. Reset the form and hide the modal
                categoryForm.reset();
                addCategoryModal.hide();
            });
        });
    </script>
</body>
</html>