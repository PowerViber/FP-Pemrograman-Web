<?php
include 'db.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success = '';

// Fetch current user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hashed_password = $user['password']; // Default to current password if no new password is provided

    // Update password if a new one is provided
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Handle file upload if a new image is provided
    $image = $user['image']; // Default to current image if no new image is provided
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/users/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate file type (only allow jpg, jpeg, png, gif)
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image = basename($_FILES['image']['name']);
            } else {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "Only JPG, JPEG, PNG & GIF files are allowed.";
        }
    }

    // Update user details in the database
    if (empty($error)) {
        $stmt = $pdo->prepare("UPDATE users SET username = ?, password = ?, image = ? WHERE id = ?");
        if ($stmt->execute([$username, $hashed_password, $image, $user_id])) {
            $success = "Profile updated successfully!";
            // Update session data for the username and image
            $_SESSION['username'] = $username;
            $_SESSION['image'] = $image;
        } else {
            $error = "Error: Could not update profile.";
        }
    }
}
?>