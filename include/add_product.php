<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $image = $_FILES['image']['name'];
    $target = "../uploads/products/" . basename($image);

    // insert database
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, type, image) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$name, $description, $price, $type, $image])) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "Product added successfully!";
        } else {
            echo "Product added, but image upload failed.";
        }
    } else {
        echo "Error: Could not add product.";
    }
}
?>
