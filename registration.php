<!-- registration.php -->
<?php
include 'navbar.php';
// Define the path to the JSON file
$json_file = 'data/users.json';

// Function to read users from the JSON file
function read_users_from_json() {
    global $json_file;
    $users_data = file_get_contents($json_file);
    return json_decode($users_data, true);
}

// Function to write users to the JSON file
function write_users_to_json($users) {
    global $json_file;
    file_put_contents($json_file, json_encode($users, JSON_PRETTY_PRINT));
}

// Function to check if email already exists in the JSON file
function email_exists($email) {
    $users = read_users_from_json();
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return true;
        }
    }
    return false;
}

// Define variables and initialize with empty values
$name = $email = $password = "";
$name_err = $email_err = $password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty(trim($_POST["name"]))) {
        $name_err = "Please enter a name.";
    } else {
        $name = trim($_POST["name"]);
    }

    // Validate email
    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif (email_exists($_POST["email"])) {
        $email_err = "This email is already taken.";
    } else {
        $email = trim($_POST["email"]);
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 8 || !preg_match('/[^a-zA-Z\d]/', trim($_POST["password"]))) {
        $password_err = "Password must be at least 8 characters long and contain at least one special character.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Check input errors before inserting into JSON file
    if (empty($name_err) && empty($email_err) && empty($password_err)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

        // Generate a unique ID for the user
        $user_id = uniqid();

        // Add user data to the JSON file
        $user_data = array('id' => $user_id, 'name' => $name, 'email' => $email, 'password' => $hashed_password);
        $users = read_users_from_json();
        $users[] = $user_data;
        write_users_to_json($users);

        // Redirect to login page after successful registration
        header("location: login.php");
        exit();
    }
}
?>

<!-- HTML code for registration form -->
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>
        <span><?php echo $name_err; ?></span>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        <span><?php echo $email_err; ?></span>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <span><?php echo $password_err; ?></span>
        <input type="submit" value="Register">
    </form>
</body>
</html>
