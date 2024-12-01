<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT id FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart = $stmt->fetch();

if ($cart) {
    $cart_id = $cart['id'];

    $stmt = $pdo->prepare("
        SELECT ci.product_id, ci.quantity, p.price
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.id
        WHERE ci.cart_id = ?
    ");
    $stmt->execute([$cart_id]);
    $cart_items = $stmt->fetchAll();

    $total_amount = 0;
    foreach ($cart_items as $item) {
        $total_amount += $item['quantity'] * $item['price'];
    }

    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, total_amount) VALUES (?, ?)");
    $stmt->execute([$user_id, $total_amount]);
    $transaction_id = $pdo->lastInsertId();

    $stmt = $pdo->prepare("INSERT INTO transaction_items (transaction_id, product_id, quantity, item_price, total_price) VALUES (?, ?, ?, ?, ?)");
    foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];
        $item_price = $item['price'];
        $total_price = $quantity * $item_price;

        $stmt->execute([$transaction_id, $product_id, $quantity, $item_price, $total_price]);
    }

    // Clear the cart after checkout
    $stmt = $pdo->prepare("DELETE FROM cart_items WHERE cart_id = ?");
    $stmt->execute([$cart_id]);

    header("Location: ../cart.php?status=checked_out");
    exit();
} else {
    echo "Your cart is empty!";
}
?>
