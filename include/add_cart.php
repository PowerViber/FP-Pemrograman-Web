<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the form was submitted with product_id and quantity
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Step 1: Check if the user has an existing cart
    $stmt = $pdo->prepare("SELECT id FROM cart WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $cart = $stmt->fetch();

    if (!$cart) {
        // If no cart exists for the user, create a new cart
        $stmt = $pdo->prepare("INSERT INTO cart (user_id) VALUES (?)");
        $stmt->execute([$user_id]);
        $cart_id = $pdo->lastInsertId();
    } else {
        // If a cart exists, use its ID
        $cart_id = $cart['id'];
    }

    // Step 2: Check if the product is already in the cart_items for this cart
    $stmt = $pdo->prepare("SELECT quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
    $stmt->execute([$cart_id, $product_id]);
    $cart_item = $stmt->fetch();

    if ($cart_item) {
        // Step 3: If the product exists in the cart, update the quantity
        $new_quantity = $cart_item['quantity'] + $quantity;
        $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE cart_id = ? AND product_id = ?");
        $stmt->execute([$new_quantity, $cart_id, $product_id]);
    } else {
        // Step 4: If the product does not exist in the cart, add it as a new item
        $stmt = $pdo->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$cart_id, $product_id, $quantity]);
    }

    // Redirect to the cart page or show a success message
    header("Location: ../cart.php");
    exit();
} else {
    echo "Invalid request!";
}
?>
