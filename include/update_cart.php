<?php
session_start();
include 'db.php';

// Redirect to login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['cart_item_id']) && isset($_POST['quantity'])) {
    $cart_item_id = (int)$_POST['cart_item_id'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity > 0) {
        // Update the quantity of the cart item
        $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        $stmt->execute([$quantity, $cart_item_id]);
    } else {
        // If quantity is zero, delete the item from the cart
        $stmt = $pdo->prepare("DELETE FROM cart_items WHERE id = ?");
        $stmt->execute([$cart_item_id]);
    }
}

// Redirect back to the cart page
header("Location: ../cart.php");
exit();
?>
