<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>View Products | Cartify Admin</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="view_products.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3><i class="fas fa-boxes"></i> All Products</h3>
            <a href="add_post.php" class="btn btn-success">
                <i class="fas fa-plus"></i> Add Product
            </a>
        </div>

        <!-- Products Grid Container - This will hold the cards -->
        <div class="products-grid" id="productTable">
            <!-- Cards will be loaded here by JavaScript -->
            <div class="loading-card">
                <i class="fas fa-spinner fa-spin"></i>
                <p>Loading products...</p>
            </div>
        </div>
    </div>

<script>
fetch("get_products.php")
.then(response => {
    if (!response.ok) {
        throw new Error('Network response was not ok');
    }
    return response.json();
})
.then(data => {
    let container = document.getElementById("productTable");
    container.innerHTML = "";

    if (data.length === 0) {
        container.innerHTML = `
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h4>No products found</h4>
                <p>Add your first product to get started</p>
            </div>`;
        return;
    }

    data.forEach((product, index) => {
        // Truncate descriptions
        const shortDesc = product.short_description ? 
            (product.short_description.length > 80 ? 
             product.short_description.substring(0, 80) + '...' : 
             product.short_description) : 'No description';
        
        // Determine status class
        let statusClass = 'status-active';
        if (product.status === 'inactive') statusClass = 'status-inactive';
        if (product.status === 'draft') statusClass = 'status-draft';
        
        // Determine stock dot
        let stockDotClass = 'stock-dot ';
        let stockText = product.stock || 0;
        if (product.stock <= 0) {
            stockDotClass += 'stock-out';
            stockText = 'Out of Stock';
        } else if (product.stock < 10) {
            stockDotClass += 'stock-low';
            stockText = 'Low Stock';
        } else {
            stockDotClass += 'stock-in';
            stockText = `${product.stock} in stock`;
        }

        container.innerHTML += `
        <div class="product-card">
            <div class="product-image-container">
                ${product.image ? 
                    `<img src="uploads/${product.image}" alt="${product.product_name}" class="object-fit-cover">` : 
                    `<div class="image-placeholder"><i class="fas fa-image"></i></div>`
                }
                <span class="status-badge ${statusClass}">${product.status || 'active'}</span>
            </div>
            
            <div class="product-content">
                <div class="product-header">
                    <div class="product-name">${product.product_name}</div>
                    <div class="product-sku">${product.sku}</div>
                </div>
                
                <div class="product-info-grid">
                    <div class="info-item">
                        <span class="info-label">Brand</span>
                        <span class="info-value">${product.brand || 'N/A'}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Price</span>
                        <span class="info-value price-value">₹${product.product_price}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Category</span>
                        <span class="info-value">${product.category || 'N/A'}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Stock</span>
                        <span class="info-value stock-value">
                            <span class="${stockDotClass}"></span>
                            ${stockText}
                        </span>
                    </div>
                </div>
                
                <div class="description-section">
                    <div class="description-label">Description</div>
                    <div class="description-text">${shortDesc}</div>
                    
                </div>
                
                <div class="product-footer">
                    <div class="created-at">
                        <i class="far fa-calendar"></i> ${product.created_at}
                    </div>
                    <div class="sold-count">
                        <i class="fas fa-shopping-cart"></i> ${product.sold_count || 0} sold
                    </div>
                </div>
            </div>
        </div>`;
    });
})
.catch(error => {
    console.error('Error:', error);
    document.getElementById("productTable").innerHTML = `
        <div class="error-state">
            <i class="fas fa-exclamation-triangle"></i>
            <h4>Error loading products</h4>
            <p>${error.message}</p>
        </div>`;
});
</script>

</body>
</html>