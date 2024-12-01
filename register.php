<?php
session_start();
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
                <a href="cart.php"><img src="resources/shoppingcart.png"></a>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Show profile picture if logged in -->
                    <a href="#" id="user-icon">
                        <img src="<?php echo isset($_SESSION['image']) ? 'uploads/users/' . htmlspecialchars($_SESSION['image']) : 'resources/user.png'; ?>" 
                            alt="Profile Picture" class="profile-pic">
                    </a>
                    <div class="user-dropdown" id="user-dropdown">
                        <ul>
                            <!-- <li><a href="profile.php">Profile</a></li> -->
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

    <div class="register-container">
        <div class="register-box">
            <h2>Register</h2>
            <form action="include/add_user.php" method="POST" enctype="multipart/form-data" class="register-form">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                
                <button type="submit">Register</button>
            </form>
        </div>
    </div>

    <script src="scripts/search.js"></script>
    <script src="scripts/hamburger.js"></script>
    <script src="scripts/user.js"></script>
</body>
</html>
