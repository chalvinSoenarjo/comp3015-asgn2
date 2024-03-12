<?php
// Start the session at the very beginning
session_start();

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Read user data from the JSON file
    $users_json = file_get_contents('data/users.json');
    $users = json_decode($users_json, true);

    foreach ($users as $user) {
        if ($user['email'] === $email) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Store user data in the session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['name']; // Store the username in the session
                var_dump($_SESSION); // Debugging line

                // Redirect to the index page after successful login
                header("Location: index.php");
                exit();
            }
        }
    }
    // Handle invalid login
    $login_error = "Invalid email or password. Please try again.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php include 'navbar.php';  ?>
    <form action="login.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <?php if (!empty($login_error)): ?>
            <p class="error"><?php echo $login_error; ?></p>
        <?php endif; ?>
        <input type="submit" value="Login">
    </form>
</body>
</html>
