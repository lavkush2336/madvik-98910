<?php
session_start();
include '../connection.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    // header("Location: login.php");
    // exit();
}

// Sample settings data
$general_settings = [
    'site_name' => 'ManavikFab',
    'site_description' => 'Premium Fashion for Women',
    'site_email' => 'info@manavikfab.com',
    'site_phone' => '+91 98765 43210',
    'site_address' => '123 Fashion Street, New Delhi - 110001',
    'currency' => 'INR',
    'timezone' => 'Asia/Kolkata',
    'language' => 'English'
];

$email_settings = [
    'smtp_host' => 'smtp.gmail.com',
    'smtp_port' => '587',
    'smtp_username' => 'noreply@manavikfab.com',
    'smtp_password' => '********',
    'smtp_encryption' => 'tls',
    'from_name' => 'ManavikFab',
    'from_email' => 'noreply@manavikfab.com'
];

$payment_settings = [
    'razorpay_key' => 'rzp_test_********',
    'razorpay_secret' => '********',
    'paypal_client_id' => '********',
    'paypal_secret' => '********',
    'cod_enabled' => true,
    'online_payment_enabled' => true
];

$shipping_settings = [
    'free_shipping_threshold' => 999,
    'standard_shipping_cost' => 99,
    'express_shipping_cost' => 199,
    'delivery_time_standard' => '3-5 days',
    'delivery_time_express' => '1-2 days'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - ManavikFab Admin</title>
    <meta name="description" content="Manage website settings, configuration, and system preferences in the ManavikFab admin panel">
    <meta name="keywords" content="admin settings, website configuration, system settings, e-commerce admin">
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
        
        .settings-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .settings-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
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
        
        .nav-pills .nav-link {
            color: #6c757d;
            border-radius: 10px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
        }
        
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        
        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .slider {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        input:checked + .slider:before {
            transform: translateX(26px);
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
                        <a href="reports.php" class="sidebar-link">
                            <i class="bi bi-graph-up"></i> Reports
                        </a>
                        <a href="settings.php" class="sidebar-link active">
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
                                <i class="bi bi-gear text-primary me-2"></i>
                                Settings
                            </h2>
                            <p class="text-muted mb-0">Manage website configuration and system preferences</p>
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
                    
                    <!-- Settings Navigation -->
                    <div class="row">
                        <div class="col-md-3">
                            <div class="settings-card p-4">
                                <nav class="nav flex-column nav-pills">
                                    <a class="nav-link active" data-bs-toggle="pill" href="#general">
                                        <i class="bi bi-gear me-2"></i>General
                                    </a>
                                    <a class="nav-link" data-bs-toggle="pill" href="#email">
                                        <i class="bi bi-envelope me-2"></i>Email
                                    </a>
                                    <a class="nav-link" data-bs-toggle="pill" href="#payment">
                                        <i class="bi bi-credit-card me-2"></i>Payment
                                    </a>
                                    <a class="nav-link" data-bs-toggle="pill" href="#shipping">
                                        <i class="bi bi-truck me-2"></i>Shipping
                                    </a>
                                    <a class="nav-link" data-bs-toggle="pill" href="#security">
                                        <i class="bi bi-shield-lock me-2"></i>Security
                                    </a>
                                    <a class="nav-link" data-bs-toggle="pill" href="#backup">
                                        <i class="bi bi-cloud-arrow-up me-2"></i>Backup
                                    </a>
                                </nav>
                            </div>
                        </div>
                        
                        <div class="col-md-9">
                            <div class="tab-content">
                                <!-- General Settings -->
                                <div class="tab-pane fade show active" id="general">
                                    <div class="settings-card p-4">
                                        <h5 class="mb-4">
                                            <i class="bi bi-gear me-2"></i>General Settings
                                        </h5>
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Site Name</label>
                                                    <input type="text" class="form-control" value="<?php echo $general_settings['site_name']; ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Site Description</label>
                                                    <input type="text" class="form-control" value="<?php echo $general_settings['site_description']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Site Email</label>
                                                    <input type="email" class="form-control" value="<?php echo $general_settings['site_email']; ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Site Phone</label>
                                                    <input type="text" class="form-control" value="<?php echo $general_settings['site_phone']; ?>">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Site Address</label>
                                                <textarea class="form-control" rows="3"><?php echo $general_settings['site_address']; ?></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Currency</label>
                                                    <select class="form-select">
                                                        <option value="INR" <?php echo $general_settings['currency'] == 'INR' ? 'selected' : ''; ?>>INR (₹)</option>
                                                        <option value="USD">USD ($)</option>
                                                        <option value="EUR">EUR (€)</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Timezone</label>
                                                    <select class="form-select">
                                                        <option value="Asia/Kolkata" <?php echo $general_settings['timezone'] == 'Asia/Kolkata' ? 'selected' : ''; ?>>Asia/Kolkata</option>
                                                        <option value="UTC">UTC</option>
                                                        <option value="America/New_York">America/New_York</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">Language</label>
                                                    <select class="form-select">
                                                        <option value="English" <?php echo $general_settings['language'] == 'English' ? 'selected' : ''; ?>>English</option>
                                                        <option value="Hindi">Hindi</option>
                                                        <option value="Spanish">Spanish</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-custom">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Email Settings -->
                                <div class="tab-pane fade" id="email">
                                    <div class="settings-card p-4">
                                        <h5 class="mb-4">
                                            <i class="bi bi-envelope me-2"></i>Email Settings
                                        </h5>
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">SMTP Host</label>
                                                    <input type="text" class="form-control" value="<?php echo $email_settings['smtp_host']; ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">SMTP Port</label>
                                                    <input type="number" class="form-control" value="<?php echo $email_settings['smtp_port']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">SMTP Username</label>
                                                    <input type="email" class="form-control" value="<?php echo $email_settings['smtp_username']; ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">SMTP Password</label>
                                                    <input type="password" class="form-control" value="<?php echo $email_settings['smtp_password']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Encryption</label>
                                                    <select class="form-select">
                                                        <option value="tls" <?php echo $email_settings['smtp_encryption'] == 'tls' ? 'selected' : ''; ?>>TLS</option>
                                                        <option value="ssl">SSL</option>
                                                        <option value="none">None</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">From Name</label>
                                                    <input type="text" class="form-control" value="<?php echo $email_settings['from_name']; ?>">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">From Email</label>
                                                <input type="email" class="form-control" value="<?php echo $email_settings['from_email']; ?>">
                                            </div>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-outline-secondary me-2">Test Email</button>
                                                <button type="submit" class="btn btn-custom">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Payment Settings -->
                                <div class="tab-pane fade" id="payment">
                                    <div class="settings-card p-4">
                                        <h5 class="mb-4">
                                            <i class="bi bi-credit-card me-2"></i>Payment Settings
                                        </h5>
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Razorpay Key</label>
                                                    <input type="text" class="form-control" value="<?php echo $payment_settings['razorpay_key']; ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Razorpay Secret</label>
                                                    <input type="password" class="form-control" value="<?php echo $payment_settings['razorpay_secret']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">PayPal Client ID</label>
                                                    <input type="text" class="form-control" value="<?php echo $payment_settings['paypal_client_id']; ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">PayPal Secret</label>
                                                    <input type="password" class="form-control" value="<?php echo $payment_settings['paypal_secret']; ?>">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label d-flex align-items-center">
                                                        <span class="me-3">Cash on Delivery</span>
                                                        <label class="switch">
                                                            <input type="checkbox" <?php echo $payment_settings['cod_enabled'] ? 'checked' : ''; ?>>
                                                            <span class="slider"></span>
                                                        </label>
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label d-flex align-items-center">
                                                        <span class="me-3">Online Payment</span>
                                                        <label class="switch">
                                                            <input type="checkbox" <?php echo $payment_settings['online_payment_enabled'] ? 'checked' : ''; ?>>
                                                            <span class="slider"></span>
                                                        </label>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-custom">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Shipping Settings -->
                                <div class="tab-pane fade" id="shipping">
                                    <div class="settings-card p-4">
                                        <h5 class="mb-4">
                                            <i class="bi bi-truck me-2"></i>Shipping Settings
                                        </h5>
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Free Shipping Threshold (₹)</label>
                                                    <input type="number" class="form-control" value="<?php echo $shipping_settings['free_shipping_threshold']; ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Standard Shipping Cost (₹)</label>
                                                    <input type="number" class="form-control" value="<?php echo $shipping_settings['standard_shipping_cost']; ?>">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Express Shipping Cost (₹)</label>
                                                    <input type="number" class="form-control" value="<?php echo $shipping_settings['express_shipping_cost']; ?>">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Standard Delivery Time</label>
                                                    <input type="text" class="form-control" value="<?php echo $shipping_settings['delivery_time_standard']; ?>">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Express Delivery Time</label>
                                                <input type="text" class="form-control" value="<?php echo $shipping_settings['delivery_time_express']; ?>">
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-custom">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Security Settings -->
                                <div class="tab-pane fade" id="security">
                                    <div class="settings-card p-4">
                                        <h5 class="mb-4">
                                            <i class="bi bi-shield-lock me-2"></i>Security Settings
                                        </h5>
                                        <form>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Current Password</label>
                                                    <input type="password" class="form-control">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">New Password</label>
                                                    <input type="password" class="form-control">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Confirm New Password</label>
                                                <input type="password" class="form-control">
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label d-flex align-items-center">
                                                        <span class="me-3">Two-Factor Authentication</span>
                                                        <label class="switch">
                                                            <input type="checkbox">
                                                            <span class="slider"></span>
                                                        </label>
                                                    </label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label d-flex align-items-center">
                                                        <span class="me-3">Login Notifications</span>
                                                        <label class="switch">
                                                            <input type="checkbox" checked>
                                                            <span class="slider"></span>
                                                        </label>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-custom">Update Password</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Backup Settings -->
                                <div class="tab-pane fade" id="backup">
                                    <div class="settings-card p-4">
                                        <h5 class="mb-4">
                                            <i class="bi bi-cloud-arrow-up me-2"></i>Backup Settings
                                        </h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <i class="bi bi-download text-primary" style="font-size: 3rem;"></i>
                                                        <h6 class="mt-3">Download Backup</h6>
                                                        <p class="text-muted">Download a complete backup of your data</p>
                                                        <button class="btn btn-custom">Download Backup</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <i class="bi bi-upload text-success" style="font-size: 3rem;"></i>
                                                        <h6 class="mt-3">Restore Backup</h6>
                                                        <p class="text-muted">Restore from a previous backup file</p>
                                                        <button class="btn btn-outline-success">Restore Backup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h6>Automatic Backup Settings</h6>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label d-flex align-items-center">
                                                            <span class="me-3">Enable Auto Backup</span>
                                                            <label class="switch">
                                                                <input type="checkbox" checked>
                                                                <span class="slider"></span>
                                                            </label>
                                                        </label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Backup Frequency</label>
                                                        <select class="form-select">
                                                            <option value="daily">Daily</option>
                                                            <option value="weekly">Weekly</option>
                                                            <option value="monthly">Monthly</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        // Add event listeners for form submissions
        document.addEventListener('DOMContentLoaded', function() {
            // Handle form submissions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    // Add your form submission logic here
                    alert('Settings saved successfully!');
                });
            });
            
            // Handle test email button
            const testEmailBtn = document.querySelector('button[type="button"]');
            if(testEmailBtn && testEmailBtn.textContent.includes('Test Email')) {
                testEmailBtn.addEventListener('click', function() {
                    alert('Test email sent!');
                });
            }
            
            console.log('Settings page loaded');
        });
    </script>
</body>
</html> 