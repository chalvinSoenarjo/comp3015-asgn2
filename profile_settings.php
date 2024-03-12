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
    if(isset($_FILES['photo'])){
        $errors= array();
        $file_name = $_FILES['photo']['name'];
        $file_size =$_FILES['photo']['size'];
        $file_tmp =$_FILES['photo']['tmp_name'];
        $file_type=$_FILES['photo']['type'];
        $file_ext=strtolower(end(explode('.',$_FILES['photo']['name'])));
      
        $extensions= array("jpeg","jpg","png");
      
        if(in_array($file_ext,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
      
        if($file_size > 2097152){
            $errors[]='File size must be exactly 2 MB';
        }
      
        if(empty($errors)==true){
            $target_dir = "images/";
            $target_file = $target_dir . basename($file_name);
            move_uploaded_file($file_tmp, $target_file);
            $_SESSION['profile_pic'] = $target_file; // Store the image path in the session
            echo "Success";
        }else{
            print_r($errors);
        }
    }
    // Update session or database with the new username and/or photo path
    $_SESSION['username'] = $updatedUsername;
    // No need to update profile_pic here, it's already updated after successful file upload
    // $_SESSION['profile_pic'] = "images/".$file_name;
    // Redirect to profile or another page if needed
    header("Location: profile_settings.php");
    exit();
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
    <form action="profile_settings.php" method="post" enctype="multipart/form-data">
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
