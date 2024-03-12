<?php
include 'navbar.php';

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["user_id"])){
    header("location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $link = $_POST['link'];

    // Validate inputs
    // ...

    // Save to JSON file
    $json = file_get_contents('data/articles.json');
    if ($json === false) {
        die('Error reading articles.json');
    }
    $articles = json_decode($json, true);
    if ($articles === null) {
        die('Error decoding articles.json');
    }

    $id = time(); // Generate ID
    $userId = $_SESSION['user_id']; // Get the user ID from the session
    $username = $_SESSION['username']; // Get the username from the session
    $createdAt = date('l jS \of F Y, h:i A'); // Get the current date and time
    $article = ['id' => $id, 'title' => $title, 'link' => $link, 'userId' => $userId, 'username' => $username, 'createdAt' => $createdAt];
    $articles[] = $article;

    $success = file_put_contents('data/articles.json', json_encode($articles));
    if ($success === false) {
        die('Error writing articles.json');
    }

    // Redirect to index.php
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Article</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <form action="submit_article.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        
        <label for="link">Link:</label>
        <input type="url" id="link" name="link" required>
        
        <input type="submit" value="Submit Article">
    </form>
</body>
</html>
