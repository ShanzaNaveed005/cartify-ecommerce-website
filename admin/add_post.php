<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Cartify Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="add_post.css">
</head>
<body>
    <div class="admin-wrapper">
        <header class="admin-header">
            <div class="header-container">
                <div class="brand">
                    <i class="fas fa-shopping-cart"></i>
                    <h1>Cartify<span>Admin</span></h1>
                </div>
                <div class="admin-info">
                    <div class="admin-details">
                        <i class="fas fa-user-circle"></i>
                        <div>
                            <h4>Admin Panel</h4>
                            <p>Product Management</p>
                        </div>
                    </div>
                    <a href="admin_dash.php" class="back-btn">
                        <i class="fas fa-arrow-left"></i>
                        Dashboard
                    </a>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="form-container">
                <div class="page-header">
                    <div class="header-content">
                        <h2><i class="fas fa-plus-circle"></i> Add New Product</h2>
                        <p>Fill in the product details below to add a new item to your store</p>
                    </div>
                    <div class="header-actions">
                        <button type="button" class="btn-secondary" onclick="clearForm()">
                            <i class="fas fa-redo"></i>
                            Clear Form
                        </button>
                    </div>
                </div>

                <form action="save_product.php" method="POST" enctype="multipart/form-data" class="product-form" id="productForm">
                    
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-info-circle"></i>
                            <h3>Basic Information</h3>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="product_name">
                                    <i class="fas fa-tag"></i>
                                    Product Name *
                                </label>
                                <input type="text" id="product_name" name="product_name" placeholder="Enter product name" required>
                                <div class="form-hint">Enter the complete product name</div>
                            </div>

                            <div class="form-group">
                                <label for="sku">
                                    <i class="fas fa-barcode"></i>
                                    SKU Code *
                                </label>
                                <input type="text" id="sku" name="sku" placeholder="e.g., PROD-001" required>
                                <div class="form-hint">Unique product identifier</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="brand">
                                    <i class="fas fa-copyright"></i>
                                    Brand Name
                                </label>
                                <input type="text" id="brand" name="brand" placeholder="Enter brand name">
                            </div>

                            <div class="form-group">
                                <label for="category">
                                    <i class="fas fa-tags"></i>
                                    Category *
                                </label>
                                <select id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="electronics">Electronics</option>
                                    <option value="mobile">Mobile Phones</option>
                                    <option value="laptops">Laptops & Computers</option>
                                    <option value="fashion">Fashion & Clothing</option>
                                    <option value="beauty">Beauty & Cosmetics</option>
                                    <option value="home">Home & Kitchen</option>
                                    <option value="sports">Sports & Fitness</option>
                                    <option value="books">Books & Stationery</option>
                                    <option value="toys">Toys & Games</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-dollar-sign"></i>
                            <h3>Pricing & Inventory</h3>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="product_price">
                                    <i class="fas fa-money-bill-wave"></i>
                                    Product Price *
                                </label>
                                <div class="input-with-icon">
                                    <span class="currency">RS:&nbsp;&nbsp;</span>
                                    <input type="number" id="product_price" name="product_price" placeholder="0.00" step="0.01" min="0" required>
                                </div>
                                <div class="form-hint">Base selling price</div>
                            </div>

                            <div class="form-group">
                                <label for="discount_price">
                                    <i class="fas fa-percentage"></i>
                                    Discount Price
                                </label>
                                <div class="input-with-icon">
                                    <span class="currency">RS:&nbsp;&nbsp;</span>
                                    <input type="number" id="discount_price" name="discount_price" placeholder="0.00" step="0.01" min="0">
                                </div>
                                <div class="form-hint">Special offer price (optional)</div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="stock">
                                    <i class="fas fa-boxes"></i>
                                    Stock Quantity *
                                </label>
                                <input type="number" id="stock" name="stock" value="0" min="0" required>
                                <div class="form-hint">Available units in inventory</div>
                            </div>

                            <div class="form-group">
                                <label for="sold_count">
                                    <i class="fas fa-shopping-cart"></i>
                                    Total Sold
                                </label>
                                <input type="number" id="sold_count" name="sold_count" value="0" min="0">
                                <div class="form-hint">Units sold to date</div>
                            </div>

                            <div class="form-group">
                                <label for="status">
                                    <i class="fas fa-toggle-on"></i>
                                    Product Status
                                </label>
                                <select id="status" name="status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-images"></i>
                            <h3>Product Image</h3>
                        </div>
                        
                        <div class="image-upload-area">
                            <div class="upload-box" id="uploadBox">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <h4>Upload Product Image</h4>
                                <p>Drag & drop or click to browse</p>
                                <input type="file" id="product_image" name="product_image" accept="image/*" required hidden>
                                <button type="button" class="btn-upload" onclick="document.getElementById('product_image').click()">
                                    <i class="fas fa-folder-open"></i>
                                    Choose File
                                </button>
                                <p class="file-info">Supports: JPG, PNG, GIF | Max: 5MB</p>
                            </div>
                            <div class="image-preview" id="imagePreview">
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                    <p>No image selected</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-align-left"></i>
                            <h3>Product Description</h3>
                        </div>
                        
                        <div class="form-group">
                            <label for="short_description">
                                <i class="fas fa-text-height"></i>
                                Short Description
                            </label>
                            <input type="text" id="short_description" name="short_description" placeholder="Brief product summary (50-100 characters)">
                            <div class="form-hint">Appears in product listings</div>
                        </div>

                        <div class="form-group">
                            <label for="description">
                                <i class="fas fa-file-alt"></i>
                                Full Description
                            </label>
                            <textarea id="description" name="description" rows="6" placeholder="Detailed product description with features, specifications, etc."></textarea>
                            <div class="form-hint">Include all relevant details for customers</div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="action-buttons">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                Save Product
                            </button>
                            <button type="button" class="btn-secondary" onclick="saveAsDraft()">
                                <i class="fas fa-file-draft"></i>
                                Save as Draft
                            </button>
                            <a href="admin_dash.php" class="btn-cancel">
                                <i class="fas fa-times"></i>
                                Cancel
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </main>

        <footer class="admin-footer">
            <p>Cartify Admin Panel &copy; 2023 | Product Management System</p>
        </footer>
    </div>

      <script>
        // Image upload preview functionality
        document.getElementById('product_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('imagePreview');
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <div class="preview-container">
                            <img src="${e.target.result}" alt="Product Preview">
                            <div class="preview-info">
                                <h5>${file.name}</h5>
                                <p>${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                                <button type="button" class="btn-remove" onclick="removeImage()">
                                    <i class="fas fa-times"></i> Remove
                                </button>
                            </div>
                        </div>
                    `;
                };
                
                reader.readAsDataURL(file);
                
                // Update upload box style
                document.getElementById('uploadBox').classList.add('has-image');
            }
        });

        function removeImage() {
            document.getElementById('product_image').value = '';
            document.getElementById('imagePreview').innerHTML = `
                <div class="no-image">
                    <i class="fas fa-image"></i>
                    <p>No image selected</p>
                </div>
            `;
            document.getElementById('uploadBox').classList.remove('has-image');
        }

        // Drag and drop functionality
        const uploadBox = document.getElementById('uploadBox');
        
        uploadBox.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadBox.classList.add('dragover');
        });

        uploadBox.addEventListener('dragleave', () => {
            uploadBox.classList.remove('dragover');
        });

        uploadBox.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadBox.classList.remove('dragover');
            
            if (e.dataTransfer.files.length) {
                document.getElementById('product_image').files = e.dataTransfer.files;
                document.getElementById('product_image').dispatchEvent(new Event('change'));
            }
        });

        // Form functions
        function clearForm() {
            if (confirm('Are you sure you want to clear all form fields?')) {
                document.getElementById('productForm').reset();
                removeImage();
            }
        }

        function saveAsDraft() {
            document.getElementById('status').value = 'draft';
            document.getElementById('productForm').submit();
        }

        // Form validation
        document.getElementById('productForm').addEventListener('submit', function(e) {
            const price = parseFloat(document.getElementById('product_price').value);
            const discount = parseFloat(document.getElementById('discount_price').value);
            
            if (price <= 0) {
                e.preventDefault();
                alert('Product price must be greater than 0.');
                return false;
            }
            
            if (discount > 0 && discount >= price) {
                e.preventDefault();
                alert('Discount price must be less than the original price.');
                return false;
            }
            
            return true;
        });
    </script>
</body>
</html>