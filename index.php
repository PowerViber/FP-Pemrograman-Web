<?php
session_start();
include 'include/db.php'; // Assuming this file sets up the PDO connection

// Fetch the username if user is logged in
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
                <a href="cart.php"><img src="resources/shoppingcart.png"></a>

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
        <section id="home" class="home-section">
            <div class="home-content">
                <div class="home-text">
                    <h1>Power Meets Precision</h1>
                    <p>Experience top-tier gaming and performance with the Victus 16, featuring an NVIDIA RTX 4060 and Intel Core i7 for seamless multitasking.</p>
                    <form action="store.php" method="get">
                        <button type="submit" class="buy-now-btn">Buy now</button>
                    </form>
                </div>
                <div class="home-image">
                    <img src="uploads/products/victus16.png">
                </div>
            </div>

            <div class="home-content">
                <div class="home-text">
                    <h1>Crystal Clear Display</h1>
                    <p>Explore the beauty of high-definition displays with our newest line of Crystal UHD TVs. Now available with incredible savings.</p>
                    <form action="store.php" method="get">
                        <button type="submit" class="buy-now-btn">Shop now</button>
                    </form>
                </div>
                <div class="home-image">
                    <img src="uploads/products/samsungtv.png">
                </div>
            </div>

            <div class="home-content">
                <div class="home-text">
                    <h1>Power in Your Hands</h1>
                    <p>Featuring lightning-fast 5G connectivity, the Redmi Note 13 Pro offers a stunning display and top-notch performance with its Snapdragon processor.</p>
                    <form action="store.php" method="get">
                        <button type="submit" class="buy-now-btn">Buy now</button>
                    </form>
                </div>
                <div class="home-image">
                    <img src="uploads/products/redminote13pro5g.png">
                </div>
            </div>

            <button class="carousel-control prev" id="prev">&#10094;</button>
            <button class="carousel-control next" id="next">&#10095;</button>
        </section>
    </div>

    

    <footer class="footer" id="contact">
        <div class="footer-top">
            <div class="footer-logo">
                <a href="#">
                    <img src="resources/EasyLek.png" alt="Logo">
                </a>
                <p style="margin-left: 10px;"><b>The heart of tech</b></p>
                
                <div class="footer-social" style="margin-left: 10px;">
                    <a href="https://www.instagram.com/arianzareihan/" target="_blank">
                        <img src="resources/instagram.png" alt="Instagram">
                    </a>
                    <a href="mailto:arianza429@gmail.com">
                        <img src="resources/email.png" alt="Email">
                    </a>
                    <a href="https://www.linkedin.com/in/reihan-arianza-970413261/?trk=public_profile_browsemap&originalSubdomain=id" target="_blank">
                        <img src="resources/linkedin.png" alt="LinkedIn">
                    </a>
                    <a href="https://x.com/Reihan00420665" target="_blank">
                        <img src="resources/twitter.png" alt="Twitter">
                    </a>
                </div>
            </div>

            <div class="footer-links">
                <div class="link-section">
                    <h4>More EasyLek</h4>
                    <ul>
                        <li><a href="#">Media</a></li>
                        <li><a href="#">Events</a></li>
                        <li><a href="#">Programs</a></li>
                        <li><a href="#">Jobs in tech</a></li>
                    </ul>
                </div>
                <div class="link-section">
                    <h4>About EasyLek</h4>
                    <ul>
                        <li><a href="#">Partner with us</a></li>
                        <li><a href="#">Jobs</a></li>
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Editorial Policy</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>A Tech company</p>
            <p>&copy; 2024-2024</p>
        </div>
    </footer>




    <script src="scripts/search.js"></script>
    <script src="scripts/carousel.js"></script>
    <script src="scripts/hamburger.js"></script>
    <script src="scripts/user.js"></script>
</body>
</html>
