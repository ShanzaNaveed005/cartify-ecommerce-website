<?php
session_start();
require_once __DIR__ . '/../config/db.php';

require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!empty($_SESSION['cart'])) {
    $items = $_SESSION['cart'];
} elseif (!empty($_SESSION['buy_now'])) {
    $items = [$_SESSION['buy_now']];
} else {
    $items = [];
}


$total = 0;
foreach ($items as $item) {
    $total += ($item['price'] * $item['qty']);
}

$errors = [];
$success = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $address    = trim($_POST['address'] ?? '');
    $city       = trim($_POST['city'] ?? '');
    $state      = trim($_POST['state'] ?? '');
    $country    = trim($_POST['country'] ?? '');
    $zip_code   = trim($_POST['zip_code'] ?? '');

    /* ===== VALIDATION ===== */
    if ($first_name == '') $errors[] = "First name required";
    if ($last_name == '')  $errors[] = "Last name required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required";
    if ($phone == '') $errors[] = "Phone required";
    if ($address == '') $errors[] = "Address required";

    if (empty($errors)) {

   
        $order_number = 'ORD-' . date('Ymd') . '-' . rand(1000,9999);


        $stmt = $conn->prepare("
            INSERT INTO orders
            (first_name,last_name,email,phone,address,city,state,country,zip_code,
             order_number,total_amount,total_orders,total_spent)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,1,?)
        ");

        $stmt->bind_param(
            "ssssssssssdd",
            $first_name,
            $last_name,
            $email,
            $phone,
            $address,
            $city,
            $state,
            $country,
            $zip_code,
            $order_number,
            $total,
            $total
        );

        if (!$stmt->execute()) {
            $errors[] = "Order save failed";
        } else {

            /* ===== SEND EMAIL ===== */
            try {
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'irsaraazaq5@gmail.com';
                $mail->Password   = 'qruz xnkl qmpa vpgd';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;

                $mail->setFrom('irsaraazaq5@gmail.com', 'Cartify');
                $mail->addAddress($email, $first_name . ' ' . $last_name);

                $mail->Subject = "Order Confirmation - $order_number";

                $body  = "Hi $first_name,\n\n";
                $body .= "Your order has been confirmed.\n\n";
                $body .= "Order Number: $order_number\n\n";
                foreach ($items as $i) {
                    $body .= $i['name'] . " x " . $i['qty'] . " = Rs " . ($i['qty'] * $i['price']) . "\n";
                }
                $body .= "\nTotal: Rs $total\n\n";
                $body .= "Thank you for shopping with Cartify!";

                $mail->Body = $body;
                $mail->send();

                $success = "✅ Order placed successfully!<br>
                            Order Number: <b>$order_number</b><br>
                            Confirmation email sent to <b>$email</b>";

                unset($_SESSION['cart'], $_SESSION['buy_now']);

            } catch (Exception $e) {
                $success = "✅ Order placed successfully!<br>
                            Order Number: <b>$order_number</b><br>
                            (Email could not be sent)";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Cartify</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #FFFBF0;
            color: #333333;
            line-height: 1.6;
            padding: 20px;
            min-height: 100vh;
        }
        
        .checkout-header {
            background-color: #FFFFFF;
            box-shadow: 0 2px 20px rgba(46, 125, 50, 0.1);
            padding: 15px 5%;
            border-radius: 10px;
            margin-bottom: 30px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
            border-left: 5px solid #2E7D32;
        }
        
        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .logo-icon {
            background-color: #2E7D32;
            color: #FFFFFF;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 20px;
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: 800;
            color: #1B5E20;
        }
        
        .logo-text span {
            color: #8D6E63;
        }
        
        .back-link {
            margin-top: 10px;
            display: inline-block;
            color: #2E7D32;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #FFFFFF;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(46, 125, 50, 0.1);
            padding: 30px;
            border: 1px solid #F5F5DC;
        }
        
        h2 {
            color: #1B5E20;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #F5F5DC;
            font-size: 28px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        h2 i {
            color: #2E7D32;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: 500;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .order-summary {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            border: 1px solid #F5F5DC;
        }
        
        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #F5F5DC;
        }
        
        .order-item:last-child {
            border-bottom: none;
        }
        
        .item-name {
            color: #5D4037;
            font-weight: 500;
        }
        
        .item-qty {
            color: #8D6E63;
            font-size: 14px;
            margin-left: 10px;
        }
        
        .item-price {
            color: #2E7D32;
            font-weight: 600;
        }
        
        .total-amount {
            text-align: right;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #2E7D32;
            font-size: 24px;
            font-weight: 700;
            color: #2E7D32;
        }
        
        .customer-form {
            margin-top: 25px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            color: #5D4037;
            margin-bottom: 8px;
            font-weight: 500;
        }
        
        label i {
            color: #2E7D32;
            margin-right: 8px;
        }
        
        input, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #F5F5DC;
            border-radius: 6px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: #FFFBF0;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #2E7D32;
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.1);
        }
        
        .submit-btn {
            background: linear-gradient(to right, #2E7D32, #4CAF50);
            color: #FFFFFF;
            border: none;
            padding: 18px 30px;
            border-radius: 6px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        
        .submit-btn:hover {
            background: linear-gradient(to right, #1B5E20, #2E7D32);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.3);
        }
        
        .submit-btn:active {
            transform: translateY(0);
        }
        
        .empty-cart {
            text-align: center;
            padding: 50px 20px;
        }
        
        .empty-icon {
            font-size: 60px;
            color: #8D6E63;
            margin-bottom: 20px;
        }
        
        .empty-message {
            color: #5D4037;
            font-size: 20px;
            margin-bottom: 20px;
        }
        
        .continue-btn {
            display: inline-block;
            background: #F5F5DC;
            color: #2E7D32;
            padding: 12px 30px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            border: 2px solid #2E7D32;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .continue-btn:hover {
            background: #2E7D32;
            color: #FFFFFF;
        }
        
        .checkout-footer {
            text-align: center;
            padding: 20px;
            color: #8D6E63;
            font-size: 14px;
            margin-top: 40px;
            border-top: 1px solid #F5F5DC;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            h2 {
                font-size: 24px;
            }
            
            .order-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .item-price {
                align-self: flex-end;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            
            .checkout-header {
                padding: 15px;
            }
            
            .container {
                padding: 15px;
            }
            
            h2 {
                font-size: 20px;
            }
            
            .submit-btn {
                padding: 15px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="checkout-header">
        <a href="main_page.html" class="logo">
            <div class="logo-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="logo-text">Cartify<span>.</span></div>
        </a>
        <a href="main_page.php" class="back-link">
            <i class="fas fa-arrow-left"></i> Back to Shopping
        </a>
    </div>
    
    <!-- Main Container -->
    <div class="container">
        <h2><i class="fas fa-shopping-bag"></i> Checkout</h2>
        
        <!-- Success Message -->
        <?php if($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                <div style="margin-top: 15px;">
                    <a href="main_page.html" class="continue-btn">
                        <i class="fas fa-shopping-bag"></i> Continue Shopping
                    </a>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Error Messages -->
        <?php if($errors): ?>
            <div class="alert alert-error">
                <?php foreach($errors as $e): ?>
                    <p><i class="fas fa-exclamation-circle"></i> <?php echo $e; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if(!$success && empty($items)): ?>
            <!-- Empty Cart -->
            <div class="empty-cart">
                <div class="empty-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h3 class="empty-message">Your cart is empty</h3>
                <p style="color: #8D6E63; margin-bottom: 20px;">Add some items to your cart before checkout</p>
                <a href="main_page.php" class="continue-btn">
                    <i class="fas fa-shopping-bag"></i> Continue Shopping
                </a>
            </div>
        
        <?php elseif(!$success): ?>
            <!-- Order Summary -->
            <div class="order-summary">
                <h3 style="color: #5D4037; margin: 0 0 15px 0;"><i class="fas fa-receipt"></i> Order Summary</h3>
                
                <?php foreach($items as $i): ?>
                <div class="order-item">
                    <div>
                        <span class="item-name"><?php echo htmlspecialchars($i['name']); ?></span>
                        <span class="item-qty">x<?php echo $i['qty']; ?></span>
                    </div>
                    <div class="item-price">
                        Rs <?php echo number_format($i['qty'] * $i['price'], 2); ?>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="total-amount">
                    Rs <?php echo number_format($total, 2); ?>
                </div>
            </div>
            
            <!-- Customer Form -->
            <div class="customer-form">
                <h3 style="color: #5D4037; margin: 25px 0 15px 0;"><i class="fas fa-user-circle"></i> Customer Information</h3>
                
                <form method="POST" id="checkoutForm">
                    <div class="form-group">
                        <label for="first_name"><i class="fas fa-user"></i> First Name *</label>
                        <input type="text" id="first_name" name="first_name" required 
                               placeholder="Enter your first name"
                               value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name"><i class="fas fa-user"></i> Last Name *</label>
                        <input type="text" id="last_name" name="last_name" required 
                               placeholder="Enter your last name"
                               value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope"></i> Email Address *</label>
                        <input type="email" id="email" name="email" required 
                               placeholder="Enter your email address"
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone"><i class="fas fa-phone"></i> Phone Number *</label>
                        <input type="tel" id="phone" name="phone" required 
                               placeholder="Enter your phone number"
                               value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="address"><i class="fas fa-home"></i> Full Address *</label>
                        <textarea id="address" name="address" rows="3" required 
                                  placeholder="Enter your complete address"><?php echo isset($_POST['address']) ? htmlspecialchars($_POST['address']) : ''; ?></textarea>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label for="city"><i class="fas fa-city"></i> City *</label>
                            <input type="text" id="city" name="city" required 
                                   placeholder="Enter your city"
                                   value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="state"><i class="fas fa-map-marked-alt"></i> State *</label>
                            <input type="text" id="state" name="state" required 
                                   placeholder="Enter your state"
                                   value="<?php echo isset($_POST['state']) ? htmlspecialchars($_POST['state']) : ''; ?>">
                        </div>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label for="country"><i class="fas fa-globe"></i> Country</label>
                            <input type="text" id="country" name="country" 
                                   placeholder="Enter your country"
                                   value="<?php echo isset($_POST['country']) ? htmlspecialchars($_POST['country']) : 'Pakistan'; ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="zip_code"><i class="fas fa-mail-bulk"></i> ZIP/Postal Code *</label>
                            <input type="text" id="zip_code" name="zip_code" required 
                                   placeholder="Enter your ZIP code"
                                   value="<?php echo isset($_POST['zip_code']) ? htmlspecialchars($_POST['zip_code']) : ''; ?>">
                        </div>
                    </div>
                    
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-lock"></i> Place Order Securely
                    </button>
                    
                    <p style="text-align: center; margin-top: 15px; color: #8D6E63; font-size: 14px;">
                        <i class="fas fa-shield-alt"></i> Your information is secure and encrypted
                    </p>
                </form>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Footer -->
    <div class="checkout-footer">
        <p>&copy; <?php echo date('Y'); ?> Cartify. All rights reserved.</p>
        <p style="margin-top: 5px; font-size: 12px;">
            <i class="fas fa-lock"></i> Secure Checkout | 
            <i class="fas fa-shield-alt"></i> SSL Encrypted
        </p>
    </div>
    
    <script>
        // Form submission loading
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkoutForm');
            if(form) {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('.submit-btn');
                    if(submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
                        submitBtn.disabled = true;
                    }
                });
            }
        });
    </script>
</body>
</html>