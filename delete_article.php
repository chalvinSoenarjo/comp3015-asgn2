<?php


// Start the session
session_start();

// Assuming you have a function to get an article by its ID
$article = get_article_by_id($_GET['id']);

// Check if the user is logged in and is the author of the article
if(!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== $article['userId']) {
    // The user is not logged in or is not the author of the article
    header("Location: access_denied.php");
    exit;
}



if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Load articles from JSON file
    $json = file_get_contents('data/articles.json');
    if ($json === false) {
        die('Error reading articles.json');
    }

    $articles = json_decode($json, true);
    if ($articles === null) {
        die('Error decoding articles.json');
    }

    // Find the index of the article to delete
    $articleIndex = null;
    foreach ($articles as $key => $article) {
        if ($article['id'] == $id) {
            $articleIndex = $key;
            break;
        }
    }

    if ($articleIndex === null) {
        die('Article not found');
    }

    // Remove the article from the array
    array_splice($articles, $articleIndex, 1);

    // Save updated articles to JSON file
    $success = file_put_contents('data/articles.json', json_encode($articles));
    if ($success === false) {
        die('Error writing articles.json');
    }

    // Redirect to index.php after deletion
    header('Location: index.php');
    exit();
} else {
    die('Invalid request');
}
?>
