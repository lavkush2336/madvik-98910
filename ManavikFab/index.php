<?php
session_start();
include 'connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManavikFab - Premium Fashion for Women | Shop Latest Trends</title>
    <meta name="description" content="Discover the latest fashion trends for women at ManavikFab. Shop from our exclusive collection of ethnic wear, western wear, accessories and more. Free shipping on orders above ₹999.">
    <meta name="keywords" content="women fashion, ethnic wear, western wear, sarees, lehengas, kurtis, dresses, accessories, online shopping">
    <meta name="author" content="ManavikFab">
    <meta property="og:title" content="ManavikFab - Premium Fashion for Women">
    <meta property="og:description" content="Discover the latest fashion trends for women at ManavikFab">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://manavikfab.com">
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

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
    .hero-section {
        background: linear-gradient(135deg, #f8c9d8 0%, #f4b6cc 100%);
        min-height: 80vh;
        display: flex;
        align-items: center;
    }
    .category-card {
        background: white;
        border-radius: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    .category-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .product-card {
        background: white;
        border-radius: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
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
                    <span class="badge bg-danger ms-1">3</span>
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

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h1 class="display-4 fw-bold mb-4">Discover Your Perfect Style</h1>
                <p class="lead mb-4">Explore our exclusive collection of ethnic and western wear designed especially for the modern Indian woman.</p>
                <div class="d-flex gap-3">
                    <a href="products.php" class="btn btn-primary-custom btn-lg">Shop Now</a>
                    <a href="products.php?category=new-arrivals" class="btn btn-outline-primary btn-lg">New Arrivals</a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="images/hero-fashion.jpg" alt="Fashion Collection" class="img-fluid rounded-3 shadow">
            </div>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Shop by Category</h2>
        <div class="row g-4">
            <div class="col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="100">
                <div class="category-card text-center p-3">
                    <i class="bi bi-heart-fill text-danger" style="font-size: 2rem;"></i>
                    <h6 class="mt-3">Ethnic Wear</h6>
                    <small class="text-muted">Traditional Elegance</small>
                </div>
            </div>
            <div class="col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="200">
                <div class="category-card text-center p-3">
                    <i class="bi bi-star-fill text-warning" style="font-size: 2rem;"></i>
                    <h6 class="mt-3">Western Wear</h6>
                    <small class="text-muted">Modern Fashion</small>
                </div>
            </div>
            <div class="col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="300">
                <div class="category-card text-center p-3">
                    <i class="bi bi-gem text-info" style="font-size: 2rem;"></i>
                    <h6 class="mt-3">Sarees</h6>
                    <small class="text-muted">Timeless Beauty</small>
                </div>
            </div>
            <div class="col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="400">
                <div class="category-card text-center p-3">
                    <i class="bi bi-flower1 text-success" style="font-size: 2rem;"></i>
                    <h6 class="mt-3">Lehengas</h6>
                    <small class="text-muted">Festive Collection</small>
                </div>
            </div>
            <div class="col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="500">
                <div class="category-card text-center p-3">
                    <i class="bi bi-diamond text-primary" style="font-size: 2rem;"></i>
                    <h6 class="mt-3">Accessories</h6>
                    <small class="text-muted">Complete Your Look</small>
                </div>
            </div>
            <div class="col-md-4 col-lg-2" data-aos="fade-up" data-aos-delay="600">
                <div class="category-card text-center p-3">
                    <i class="bi bi-fire text-danger" style="font-size: 2rem;"></i>
                    <h6 class="mt-3">New Arrivals</h6>
                    <small class="text-muted">Latest Trends</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5" data-aos="fade-up">Featured Products</h2>
        <div class="row g-4">
            <?php
            // Sample featured products data
            $featured_products = [
                [
                    'name' => 'Embroidered Silk Saree',
                    'price' => '₹2,499',
                    'original_price' => '₹3,999',
                    'image' => 'images/product1.jpg',
                    'rating' => 4.5
                ],
                [
                    'name' => 'Designer Lehenga Set',
                    'price' => '₹5,999',
                    'original_price' => '₹8,999',
                    'image' => 'images/product2.jpg',
                    'rating' => 4.8
                ],
                [
                    'name' => 'Cotton Kurti with Palazzo',
                    'price' => '₹1,299',
                    'original_price' => '₹1,999',
                    'image' => 'images/product3.jpg',
                    'rating' => 4.3
                ],
                [
                    'name' => 'Western Dress Collection',
                    'price' => '₹1,899',
                    'original_price' => '₹2,499',
                    'image' => 'images/product4.jpg',
                    'rating' => 4.6
                ]
            ];
            
            foreach($featured_products as $index => $product):
            ?>
            <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
                <div class="product-card h-100">
                    <img src="<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                    <div class="card-body">
                        <h6 class="card-title"><?php echo $product['name']; ?></h6>
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-warning me-2">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="bi bi-star<?php echo $i <= $product['rating'] ? '-fill' : ''; ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <small class="text-muted">(<?php echo $product['rating']; ?>)</small>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <span class="fw-bold text-danger"><?php echo $product['price']; ?></span>
                                <small class="text-muted text-decoration-line-through"><?php echo $product['original_price']; ?></small>
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
        <div class="text-center mt-4">
            <a href="products.php" class="btn btn-primary-custom">View All Products</a>
        </div>
    </div>
</section>

<!-- Offers Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="bg-white p-4 rounded-3 shadow-sm">
                    <h4 class="text-danger mb-3">🎉 Special Offer</h4>
                    <h5>Get 50% OFF on Ethnic Collection</h5>
                    <p class="text-muted">Valid till 31st December 2024</p>
                    <a href="products.php?category=ethnic" class="btn btn-primary-custom">Shop Now</a>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="bg-white p-4 rounded-3 shadow-sm">
                    <h4 class="text-success mb-3">🚚 Free Shipping</h4>
                    <h5>Free Delivery on Orders Above ₹999</h5>
                    <p class="text-muted">Pan India delivery</p>
                    <a href="products.php" class="btn btn-primary-custom">Explore</a>
                </div>
            </div>
        </div>
    </div>
</section>

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
<!-- AOS Animation -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000,
        once: true
    });
</script>

</body>
</html>