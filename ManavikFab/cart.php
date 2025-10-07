<?php
session_start();
include 'connection.php';

// Sample cart data
$cart_items = [
    [
        'id' => 1,
        'name' => 'Embroidered Silk Saree',
        'price' => 2499,
        'original_price' => 3999,
        'image' => 'images/product1.jpg',
        'size' => 'M',
        'color' => 'Red',
        'quantity' => 1
    ],
    [
        'id' => 2,
        'name' => 'Designer Lehenga Set',
        'price' => 5999,
        'original_price' => 8999,
        'image' => 'images/product2.jpg',
        'size' => 'L',
        'color' => 'Blue',
        'quantity' => 1
    ],
    [
        'id' => 3,
        'name' => 'Cotton Kurti with Palazzo',
        'price' => 1299,
        'original_price' => 1999,
        'image' => 'images/product3.jpg',
        'size' => 'S',
        'color' => 'Green',
        'quantity' => 2
    ]
];

$subtotal = array_sum(array_map(function($item) {
    return $item['price'] * $item['quantity'];
}, $cart_items));

$shipping = $subtotal > 999 ? 0 : 200;
$tax = $subtotal * 0.18; // 18% GST
$total = $subtotal + $shipping + $tax;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - ManavikFab</title>
    <meta name="description" content="View and manage your shopping cart at ManavikFab. Secure checkout with multiple payment options.">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f8c9d8 0%, #f4b6cc 100%);
        }
        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2d2d2d;
        }
        .cart-container {
            background: white;
            border-radius: 1rem;
            padding: 2rem;
        }
        .cart-item {
            border: 1px solid #e9ecef;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #f8c9d8 0%, #f4b6cc 100%);
            border: none;
            color: #2d2d2d;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 2rem;
            transition: all 0.3s ease;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .footer {
            background: #2d2d2d;
            color: white;
        }
        .search-bar {
            border-radius: 2rem;
            border: 2px solid #f8c9d8;
            padding: 0.75rem 1.5rem;
        }
        .search-bar:focus {
            border-color: #f4b6cc;
            box-shadow: 0 0 0 0.2rem rgba(248, 201, 216, 0.3);
        }
        .quantity-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 1px solid #dee2e6;
            background: white;
            color: #6c757d;
            transition: all 0.3s ease;
        }
        .quantity-btn:hover {
            background: #f4b6cc;
            border-color: #f4b6cc;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-heart-fill text-danger me-2"></i>ManavikFab
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Categories
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="products.php?category=ethnic">Ethnic Wear</a></li>
                            <li><a class="dropdown-item" href="products.php?category=western">Western Wear</a></li>
                            <li><a class="dropdown-item" href="products.php?category=sarees">Sarees</a></li>
                            <li><a class="dropdown-item" href="products.php?category=lehengas">Lehengas</a></li>
                            <li><a class="dropdown-item" href="products.php?category=accessories">Accessories</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">All Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                
                <form class="d-flex me-3">
                    <input class="form-control search-bar" type="search" placeholder="Search for products..." aria-label="Search">
                </form>
                
                <div class="d-flex align-items-center">
                    <a href="wishlist.php" class="btn btn-outline-light me-2">
                        <i class="bi bi-heart"></i>
                    </a>
                    <a href="cart.php" class="btn btn-outline-light me-2">
                        <i class="bi bi-cart3"></i>
                        <span class="badge bg-danger ms-1"><?php echo count($cart_items); ?></span>
                    </a>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> My Account
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item" href="orders.php">My Orders</a></li>
                                <li><a class="dropdown-item" href="wishlist.php">Wishlist</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline-primary me-2">Login</a>
                        <a href="signup.php" class="btn btn-primary-custom">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="container mt-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
            </ol>
        </nav>
    </div>

    <!-- Cart Section -->
    <div class="container py-5">
        <div class="row">
            <!-- Cart Items -->
            <div class="col-lg-8 mb-4">
                <div class="cart-container">
                    <h3 class="mb-4">Shopping Cart (<?php echo count($cart_items); ?> items)</h3>
                    
                    <?php if(empty($cart_items)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-cart3 text-muted" style="font-size: 4rem;"></i>
                            <h4 class="mt-3">Your cart is empty</h4>
                            <p class="text-muted">Looks like you haven't added any items to your cart yet.</p>
                            <a href="products.php" class="btn btn-primary-custom">Start Shopping</a>
                        </div>
                    <?php else: ?>
                        <?php foreach($cart_items as $item): ?>
                        <div class="cart-item">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <img src="<?php echo $item['image']; ?>" class="img-fluid rounded" alt="<?php echo $item['name']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <h6 class="mb-1"><?php echo $item['name']; ?></h6>
                                    <small class="text-muted">Size: <?php echo $item['size']; ?> | Color: <?php echo $item['color']; ?></small>
                                </div>
                                <div class="col-md-2">
                                    <div class="d-flex align-items-center">
                                        <button class="quantity-btn" onclick="updateQuantity(<?php echo $item['id']; ?>, -1)">-</button>
                                        <span class="mx-3" id="quantity-<?php echo $item['id']; ?>"><?php echo $item['quantity']; ?></span>
                                        <button class="quantity-btn" onclick="updateQuantity(<?php echo $item['id']; ?>, 1)">+</button>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <span class="fw-bold text-danger">₹<?php echo number_format($item['price']); ?></span>
                                    <small class="text-muted text-decoration-line-through d-block">₹<?php echo number_format($item['original_price']); ?></small>
                                </div>
                                <div class="col-md-2 text-end">
                                    <span class="fw-bold">₹<?php echo number_format($item['price'] * $item['quantity']); ?></span>
                                </div>
                                <div class="col-md-1 text-end">
                                    <button class="btn btn-sm btn-outline-danger" onclick="removeItem(<?php echo $item['id']; ?>)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                        
                        <!-- Cart Actions -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="products.php" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                            </a>
                            <button class="btn btn-outline-secondary" onclick="clearCart()">
                                <i class="bi bi-trash me-2"></i>Clear Cart
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="cart-container">
                    <h4 class="mb-4">Order Summary</h4>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>₹<?php echo number_format($subtotal); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span><?php echo $shipping == 0 ? 'Free' : '₹' . number_format($shipping); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax (GST):</span>
                        <span>₹<?php echo number_format($tax); ?></span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <strong>Total:</strong>
                        <strong class="text-danger">₹<?php echo number_format($total); ?></strong>
                    </div>
                    
                    <?php if($shipping > 0): ?>
                        <div class="alert alert-info">
                            <small>Add ₹<?php echo 999 - $subtotal; ?> more to get free shipping!</small>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success">
                            <small><i class="bi bi-check-circle me-1"></i>Free shipping applied!</small>
                        </div>
                    <?php endif; ?>
                    
                    <button class="btn btn-primary-custom w-100 mb-3" onclick="proceedToCheckout()">
                        <i class="bi bi-credit-card me-2"></i>Proceed to Checkout
                    </button>
                    
                    <div class="text-center">
                        <small class="text-muted">Secure checkout with multiple payment options</small>
                    </div>
                </div>

                <!-- Coupon Code -->
                <div class="cart-container mt-4">
                    <h6 class="mb-3">Have a Coupon?</h6>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter coupon code">
                        <button class="btn btn-outline-primary">Apply</button>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="cart-container mt-4">
                    <h6 class="mb-3">Accepted Payment Methods</h6>
                    <div class="row text-center">
                        <div class="col-3">
                            <i class="bi bi-credit-card text-primary"></i>
                            <small class="d-block">Cards</small>
                        </div>
                        <div class="col-3">
                            <i class="bi bi-phone text-success"></i>
                            <small class="d-block">UPI</small>
                        </div>
                        <div class="col-3">
                            <i class="bi bi-bank text-warning"></i>
                            <small class="d-block">Net Banking</small>
                        </div>
                        <div class="col-3">
                            <i class="bi bi-cash text-info"></i>
                            <small class="d-block">COD</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recently Viewed -->
        <div class="row mt-5">
            <div class="col-12">
                <h4 class="mb-4">Recently Viewed</h4>
                <div class="row g-4">
                    <?php
                    $recent_products = [
                        [
                            'name' => 'Western Dress Collection',
                            'price' => 1899,
                            'original_price' => 2499,
                            'image' => 'images/product4.jpg'
                        ],
                        [
                            'name' => 'Bridal Lehenga Set',
                            'price' => 8999,
                            'original_price' => 12999,
                            'image' => 'images/product5.jpg'
                        ],
                        [
                            'name' => 'Silk Anarkali Suit',
                            'price' => 3499,
                            'original_price' => 4999,
                            'image' => 'images/product6.jpg'
                        ]
                    ];
                    
                    foreach($recent_products as $product):
                    ?>
                    <div class="col-md-4">
                        <div class="card h-100">
                            <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                            <div class="card-body">
                                <h6 class="card-title"><?php echo $product['name']; ?></h6>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fw-bold text-danger">₹<?php echo number_format($product['price']); ?></span>
                                        <small class="text-muted text-decoration-line-through">₹<?php echo number_format($product['original_price']); ?></small>
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="mb-3">ManavikFab</h5>
                    <p class="text-muted">Your one-stop destination for premium fashion. We bring you the latest trends in ethnic and western wear.</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-white"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <h6 class="mb-3">Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="about.php" class="text-muted text-decoration-none">About Us</a></li>
                        <li><a href="contact.php" class="text-muted text-decoration-none">Contact</a></li>
                        <li><a href="products.php" class="text-muted text-decoration-none">Products</a></li>
                        <li><a href="blog.php" class="text-muted text-decoration-none">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="mb-3">Categories</h6>
                    <ul class="list-unstyled">
                        <li><a href="products.php?category=ethnic" class="text-muted text-decoration-none">Ethnic Wear</a></li>
                        <li><a href="products.php?category=western" class="text-muted text-decoration-none">Western Wear</a></li>
                        <li><a href="products.php?category=sarees" class="text-muted text-decoration-none">Sarees</a></li>
                        <li><a href="products.php?category=accessories" class="text-muted text-decoration-none">Accessories</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="mb-3">Customer Service</h6>
                    <ul class="list-unstyled">
                        <li><a href="help.php" class="text-muted text-decoration-none">Help Center</a></li>
                        <li><a href="shipping.php" class="text-muted text-decoration-none">Shipping Info</a></li>
                        <li><a href="returns.php" class="text-muted text-decoration-none">Returns</a></li>
                        <li><a href="size-guide.php" class="text-muted text-decoration-none">Size Guide</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="mb-3">Account</h6>
                    <ul class="list-unstyled">
                        <li><a href="login.php" class="text-muted text-decoration-none">Login</a></li>
                        <li><a href="signup.php" class="text-muted text-decoration-none">Sign Up</a></li>
                        <li><a href="orders.php" class="text-muted text-decoration-none">My Orders</a></li>
                        <li><a href="wishlist.php" class="text-muted text-decoration-none">Wishlist</a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0 text-muted">&copy; 2024 ManavikFab. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <img src="images/payment-methods.png" alt="Payment Methods" class="img-fluid" style="height: 30px;">
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function updateQuantity(itemId, delta) {
            const quantityElement = document.getElementById(`quantity-${itemId}`);
            let currentQuantity = parseInt(quantityElement.textContent);
            let newQuantity = currentQuantity + delta;
            
            if (newQuantity >= 1) {
                quantityElement.textContent = newQuantity;
                updateCart();
            }
        }

        function removeItem(itemId) {
            if (confirm('Are you sure you want to remove this item from your cart?')) {
                // Remove item from cart
                const cartItem = document.querySelector(`[data-item-id="${itemId}"]`);
                if (cartItem) {
                    cartItem.remove();
                }
                updateCart();
            }
        }

        function clearCart() {
            if (confirm('Are you sure you want to clear your entire cart?')) {
                // Clear all cart items
                const cartItems = document.querySelectorAll('.cart-item');
                cartItems.forEach(item => item.remove());
                updateCart();
            }
        }

        function updateCart() {
            // Update cart totals and item count
            // This would typically make an AJAX call to update the cart
            console.log('Cart updated');
        }

        function proceedToCheckout() {
            // Redirect to checkout page
            window.location.href = 'checkout.php';
        }
    </script>
</body>
</html> 