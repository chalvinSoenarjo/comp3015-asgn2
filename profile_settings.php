<?php
// Start the session to access user information
session_start();

// Include the navbar and any necessary PHP files for database connection
include 'navbar.php'; 
// Assuming user information is stored in session or fetched from database
$userEmail = $_SESSION['user_email']; // Replace with actual session variable or database query
$userName = $_SESSION['username']; // Replace with actual session variable or database query

// Placeholder for processing form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the uploaded file and update the username
    
    // Fetch updated username from the form
    $updatedUsername = $_POST['username'];
    
    // For file upload, you'll need to handle file in $_FILES['photo']
    // Remember to check for errors, file size, and type for security
    
    // Update session or database with the new username and/or photo path
    // Redirect to profile or another page if needed
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Settings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Profile Settings</h2>
    <form action="profileSettings.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="email">Email (cannot be changed):</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($userEmail); ?>" disabled>
        </div>
        
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($userName); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" id="photo" name="photo">
        </div>
        
        <button type="submit">Save</button>
    </form>
</body>
</html>
