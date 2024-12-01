<?php
session_start();
include 'include/db.php';

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the user's cart and cart items from the database
$user_id = $_SESSION['user_id'];

// Retrieve the cart ID for the logged-in user
$stmt = $pdo->prepare("SELECT id FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch();

$cart_items = [];
$subtotal = 0;

if ($cart) {
    $cart_id = $cart['id'];

    // Retrieve the cart items for this cart
    $stmt = $pdo->prepare("
        SELECT ci.id as cart_item_id, ci.quantity, p.name, p.price, p.image, (ci.quantity * p.price) AS total
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.id
        WHERE ci.cart_id = ?
    ");
    $stmt->execute([$cart_id]);
    $cart_items = $stmt->fetchAll();

    // Calculate subtotal
    foreach ($cart_items as $item) {
        $subtotal += $item['total'];
    }
}

// Define additional costs
$shipping = 10.00;
$tax = $subtotal * 0.1; // 10% tax
$total = $subtotal + $shipping + $tax;

$username = '';
if (isset($_SESSION['user_id'])) {
    $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    $username = $user ? htmlspecialchars($user['username']) : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>5025231274</title>
    <link rel="stylesheet" href="styles/styles.css"> 
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="index.php"><img src="resources/EasyLek.png"></a>
        </div>

        <div class="navbar-container">
            <ul class="nav-links" id="nav-links">
                <li><a href="store.php">Store</a></li>
                <li><a href="mobile.php">Mobile</a></li>
                <li><a href="tv.php">TV</a></li>
                <li><a href="computing.php">Computing</a></li>
                <li><a href="#contact">Contact Us</a></li>
            </ul>
        </div>

        <div class="nav-right">
            <div class="nav-icons">
                <div class="search-container">
                    <div class="search-icon" id="search-icon"></div>
                    <input type="text" class="search-bar" id="search-bar" placeholder="Search...">
                </div>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Show profile picture if logged in -->
                    <a href="#" id="user-icon">
                        <img src="<?php echo isset($_SESSION['image']) ? 'uploads/users/' . htmlspecialchars($_SESSION['image']) : 'resources/user.png'; ?>" 
                            alt="Profile Picture" class="profile-pic">
                    </a>
                    <div class="user-dropdown" id="user-dropdown">
                        <ul>
                            <li><a href="profile.php"><?php echo $username; ?></a></li>
                            <li><a href="include/logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <!-- Show Register and Login links if not logged in -->
                    <a href="#" id="user-icon"><img src="resources/user.png"></a>
                    <div class="user-dropdown" id="user-dropdown">
                        <ul>
                            <li><a href="register.php">Register</a></li>
                            <li><a href="login.php">Login</a></li>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="hamburger" id="hamburger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <div class="content">
        <h1>Shopping Cart</h1>

        <?php if (isset($_GET['status']) && $_GET['status'] == 'checked_out'): ?>
            <p class="checkout-message">Thank you for your purchase! Your cart has been checked out.</p>
        <?php endif; ?>
        
        <div class="cart-items">
            <?php if (!empty($cart_items)): ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="cart-item">
                        <img src="uploads/products/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="product-image">
                        <div class="item-details">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p>Price: $<?php echo number_format($item['price'], 2); ?></p>

                            <!-- Quantity Update Form -->
                            <form action="include/update_cart.php" method="POST" class="quantity-form">
                                <input type="hidden" name="cart_item_id" value="<?php echo $item['cart_item_id']; ?>">
                                <label for="quantity">Quantity:</label>
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="0">
                                <button type="submit">Update</button>
                            </form>

                            <p>Total: $<?php echo number_format($item['total'], 2); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Your cart is empty.</p>
            <?php endif; ?>
        </div>

        <div class="cart-summary">
            <h3>Summary</h3>
            <p>Subtotal: $<?php echo number_format($subtotal, 2); ?></p>
            <p>Shipping: $<?php echo number_format($shipping, 2); ?></p>
            <p>Tax (10%): $<?php echo number_format($tax, 2); ?></p>
            <h3>Total: $<?php echo number_format($total, 2); ?></h3>

            <form action="include/checkout.php" method="POST">
                <button type="submit" class="checkout-btn">Proceed to Checkout</button>
            </form> 
        </div>
    </div>


    <script src="scripts/search.js"></script>
    <script src="scripts/hamburger.js"></script>
    <script src="scripts/user.js"></script>
</body>
</html>
