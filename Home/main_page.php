<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cartify - Products</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="main_page.css">
</head>

<body>
    <header>
        <div class="nav-container">
            <a href="#" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="logo-text">Cartify<span>.</span></div>
            </a>

           <ul class="nav-links">
                <li><a href="#hero-sale" class="active">HOME</a></li>
                <li><a href="#products-section">PRODUCTS</a></li>
                <li><a href="#productsGrid">CATEGORIES</a></li>
                <li><a href="#best-sellers-section">BEST SELLERS</a></li>
                <li><a href="#Contact">CONTACT</a></li>
            </ul>

            <div class="nav-icons">
                <div class="search-wrapper">
                    <input type="text" id="searchInput" placeholder="Search products..." />
                    <button id="searchBtn"><i class="fas fa-search"></i></button>
                </div>

                <a href="login_choice.php"><i class="fas fa-user"></i></a>


                <a href="cart.php" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count"><?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?></span>
                </a>
            </div>
        </div>
    </header>

    <section class="hero-sale">
        <div class="sale-content">
            <div class="sale-badge">Sale 20% Off</div>
            <h1 class="sale-title">On Everything</h1>
            <p class="sale-description">
                THE BIG EVENT IS HERE! ⚡️
                Up to 50% OFF sitewide.No stress. Just pure style. Call to Action: Tap to shop now!
            </p>
            <a href="#" class="sale-button">Shop Now</a>
        </div>
    </section>

    <section class="products-section" id="products">
    <section class="products-section">
        <div class="products-container">
            <div class="sidebar">
                <div class="sidebar-content">
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">CATEGORY</h3>
                        <ul class="category-list" id="categoryList">
                            </ul>
                    </div>

                    <div class="sidebar-section" id="best-sellers-section">
                        <h3 class="sidebar-title">BEST SELLERS</h3>
                        <div id="bestSellers"></div>
                    </div>
                </div>
            </div>

            <div class="products-main" id="products-section">
                <div class="section-header">
                    <h2 class="section-title">New <span>Products</span></h2>
                    <div class="products-count" id="productCount">0 Products</div>
                </div>

                <div class="products-grid" id="productsGrid">
                    </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content" >
            <div class="footer-column">
                <h3>Cartify.</h3>
                <p>Elevate your shopping experience with premium products, quality service, and seamless shopping.</p>
            </div>

            <div class="footer-column" id="Contact">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Products</a></li>
                    <li><a href="#">Categories</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Customer Service</h3>
                <ul class="footer-links">
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Shipping Policy</a></li>
                    <li><a href="#">Returns & Exchanges</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>Contact Us</h3>
                <ul class="footer-links">
                    <li><i class="fas fa-map-marker-alt"></i> G-9/4, Islamabad, isb</li>
                    <li><i class="fas fa-phone"></i> +1 (234) 567-8900</li>
                    <li><i class="fas fa-envelope"></i> support@cartify.com</li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            <p>&copy; 2023 Cartify. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
       
        function chooseLogin() {
            const choice = prompt("Login as:\n1. User\n2. Admin\n\nEnter 1 or 2");
            if(choice === "1") {
                window.location.href = "main_page.php"; // Or user login page
            } else if(choice === "2") {
                window.location.href = "../admin/admin_dash.php";
            } else {
                alert("Invalid choice!");
            }
        }

        function generateStars(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) stars += '<i class="fas fa-star"></i>';
                else if (i === Math.ceil(rating) && !Number.isInteger(rating)) stars += '<i class="fas fa-star-half-alt"></i>';
                else stars += '<i class="far fa-star"></i>';
            }
            return stars;
        }

        function loadCategories() {
            fetch("get_categories.php")
                .then(res => res.json())
                .then(data => {
                    const categoryList = document.getElementById('categoryList');
                    categoryList.innerHTML = '<li><a href="#" class="active" data-category="">All</a></li>';
                    data.forEach(cat => {
                        categoryList.innerHTML += `<li><a href="#" data-category="${cat}">${cat}</a></li>`;
                    });

                    document.querySelectorAll('#categoryList a').forEach(link => {
                        link.addEventListener('click', function(e) {
                            e.preventDefault();
                            document.querySelectorAll('#categoryList a').forEach(a => a.classList.remove('active'));
                            this.classList.add('active');
                            loadProducts(this.dataset.category);
                        });
                    });
                });
        }

        function loadBestSellers() {
            fetch("get_best_sellers.php")
                .then(res => res.json())
                .then(data => {
                    const div = document.getElementById("bestSellers");
                    div.innerHTML = '';
                    data.forEach(p => {
                        div.innerHTML += `
                            <div class="best-seller-item">
                                <div class="bs-image"><img src="../admin/uploads/${p.image}"></div>
                                <div class="bs-details">
                                    <div class="bs-name">${p.product_name}</div>
                                    <div class="bs-price">${p.product_price}</div>
                                </div>
                                <div class="bs-rating">${generateStars(5)}</div>
                            </div>
                        `;
                    });
                });
        }

        function loadProducts(category = '') {
            let url = "get_products_front.php";
            if (category) url += "?category=" + encodeURIComponent(category);

            fetch(url)
                .then(res => res.json())
                .then(data => {
                    const grid = document.getElementById('productsGrid');
                    grid.innerHTML = '';
                    document.getElementById('productCount').textContent = `${data.length} Products`;

                    if(data.length === 0) {
                        grid.innerHTML = `<p style="padding:20px;">No products found.</p>`;
                        return;
                    }

                    data.forEach(p => {
                        grid.innerHTML += `
                            <div class="product-card">
                                <div class="product-image"><img src="../admin/uploads/${p.image}" alt="${p.product_name}"></div>
                                <div class="product-info">
                                    <div class="product-category">${p.category}</div>
                                    <h3 class="product-name">${p.product_name}</h3>
                                    <div class="product-rating">${generateStars(4)}</div>
                                    <div class="product-price"><span class="current-price">${p.product_price}</span></div>
                                    <div class="product-actions">
                                        <a href="product_details.php?id=${p.id}" class="view-details"><i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                });
        }

        // Search functionality
        document.getElementById('searchBtn').addEventListener('click', function() {
            const query = document.getElementById('searchInput').value.trim();
            if(!query) return;
            loadProductsBySearch(query);
        });

        function loadProductsBySearch(query) {
            fetch("get_products_front.php?search=" + encodeURIComponent(query))
                .then(res => res.json())
                .then(data => {
                    const grid = document.getElementById('productsGrid');
                    grid.innerHTML = '';
                    if(data.length === 0) {
                        grid.innerHTML = `<p style="padding:20px;">No products found for "${query}"</p>`;
                        document.getElementById('productCount').textContent = "0 Products";
                        return;
                    }
                    document.getElementById('productCount').textContent = `${data.length} Products`;
                    data.forEach(p => {
                        grid.innerHTML += `
                            <div class="product-card">
                                <div class="product-image"><img src="../admin/uploads/${p.image}" alt="${p.product_name}"></div>
                                <div class="product-info">
                                    <div class="product-category">${p.category}</div>
                                    <h3 class="product-name">${p.product_name}</h3>
                                    <div class="product-rating">${generateStars(4)}</div>
                                    <div class="product-price"><span class="current-price">${p.product_price}</span></div>
                                    <div class="product-actions">
                                        <a href="product_details.php?id=${p.id}" class="view-details"><i class="fas fa-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                });
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadCategories();
            loadBestSellers();
            loadProducts();
        });
    </script>

    <style>
        
        .nav-icons {
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
        }

        .search-wrapper {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 25px;
            overflow: hidden;
            background: #fff;
        }

        .search-wrapper input {
            border: none;
            padding: 6px 12px;
            outline: none;
            width: 180px;
        }

        .search-wrapper button {
            border: none;
            background: #3e7c4f;
            color: white;
            padding: 6px 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-wrapper button i {
            font-size: 14px;
        }

        .search-wrapper input::placeholder {
            color: #999;
        }

        
        .search-wrapper button:hover {
            background: #2e5b36;
        }
    </style>
</body>
</html>