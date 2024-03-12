<?php
// Start the session
session_start();
// Define the default profile picture
$defaultProfilePic = 'images/cat.jpg'; // Update this path to your actual default cat image
$userProfilePic = isset($_SESSION['profile_pic']) && file_exists($_SESSION['profile_pic']) ? $_SESSION['profile_pic'] : $defaultProfilePic;
?>
<style>
    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .navbar-profile-pic {
        width: 40px; /* Adjust based on your preference */
        height: 40px; /* Adjust based on your preference */
        border-radius: 50%; /* Makes the image circular */
        object-fit: cover; /* Ensures the image covers the area without losing its aspect ratio */
    }
    .navbar-links {
        display: flex;
        align-items: center;
    }
    .navbar-links a, .navbar-links p {
        margin-right: 10px; /* Adds some spacing between navbar items */
    }
</style>
<div class="navbar">
    <div class="navbar-links">
       
        <?php if (!isset($_SESSION['username'])): ?>
            <!-- This section should be shown if the user is not logged in -->
            <p>Welcome, Guest</p>
            <a href="index.php">Home</a>
            <a href="submit_article.php">Submit Article</a>
            <a href="login.php">Login</a>
            <a href="registration.php">Register</a>
        <?php else: ?>
            <!-- This section should be shown if the user is logged in -->
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <a href="index.php">Home</a>
            <a href="submit_article.php">Submit Article</a>
            <a href="profile_settings.php">Profile Settings</a>
            <a href="logout.php">Logout</a>
            <!-- Make profile picture clickable -->
            <a href="profile_settings.php">
                <img src="<?php echo htmlspecialchars($userProfilePic); ?>" alt="Profile Picture" class="navbar-profile-pic">
            </a>
        <?php endif; ?>
    </div>
</div>
