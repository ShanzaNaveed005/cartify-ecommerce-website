<?php
session_start();

$login_error = '';
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_type'])) {
    $type = $_POST['login_type'];

    if($type === 'user'){
        $_SESSION['user_logged_in'] = true;
        header("Location: main_page.php#products-section");
        exit;
    }

    if($type === 'admin'){
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if($username === 'admin' && $password === '12345'){
            $_SESSION['admin_logged_in'] = true;
            header("Location: ../admin/admin_dash.php");
            exit;
        } else {
            $login_error = "Invalid admin credentials!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Choice - Cartify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="login_choice.css">
</head>
<body>
    <div class="login-choice-container">
        <!-- Header -->
        <div class="login-header">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="logo-text">Cartify<span>.</span></div>
            </div>
            <h2 class="login-title">Welcome Back</h2>
            <p class="login-subtitle">Choose how you want to login</p>
        </div>

        <?php if($login_error): ?>
            <!-- Error Message -->
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($login_error); ?>
            </div>
            
            <button class="retry-btn" onclick="window.location.href='login_choice.php'">
                <i class="fas fa-redo"></i> Try Again
            </button>
            
        <?php else: ?>
            <!-- Login Options -->
            <div class="login-options">
                <form method="POST" class="login-form">
                    <input type="hidden" name="login_type" value="user">
                    <button type="submit" class="login-option-btn user-btn">
                        <i class="fas fa-user"></i> Login as User
                    </button>
                </form>
                
                <button type="button" class="login-option-btn admin-btn" onclick="showAdminLogin()">
                    <i class="fas fa-lock"></i> Login as Admin
                </button>
            </div>

            <!-- Admin Login Form (Initially Hidden) -->
            <div class="admin-login-form" id="adminForm" style="display: none;">
                <h3 class="form-title">
                    <i class="fas fa-user-shield"></i> Admin Login
                </h3>
                
                <form method="POST">
                    <input type="hidden" name="login_type" value="admin">
                    
                    <div class="form-group">
                        <label class="form-label" for="username">
                            <i class="fas fa-user"></i> Username
                        </label>
                        <input type="text" 
                               id="username" 
                               name="username" 
                               class="form-input" 
                               placeholder="Enter admin username" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password">
                            <i class="fas fa-key"></i> Password
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="form-input" 
                               placeholder="Enter admin password" 
                               required>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-sign-in-alt"></i> Login as Admin
                    </button>
                </form>
            </div>
            
            <!-- Footer -->
            <div class="login-footer">
                <p>Continue shopping as a guest or login to access all features</p>
                <div class="security-note">
                    <i class="fas fa-shield-alt"></i>
                    <span>Your data is secure and protected</span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function showAdminLogin() {
            const adminForm = document.getElementById('adminForm');
            adminForm.style.display = 'block';
            
            // Smooth scroll to form
            adminForm.scrollIntoView({ behavior: 'smooth' });
            
            // Focus on username field
            setTimeout(() => {
                document.getElementById('username').focus();
            }, 300);
        }
        
        // Form submission loading
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if(submitBtn) {
                        const originalText = submitBtn.innerHTML;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Logging in...';
                        submitBtn.disabled = true;
                        
                        // Re-enable button after 5 seconds (in case of error)
                        setTimeout(() => {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        }, 5000);
                    }
                });
            });
        });
    </script>
</body>
</html>