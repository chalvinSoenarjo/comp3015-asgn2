<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'], $_POST['title'], $_POST['link'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $link = $_POST['link'];

    // Load articles from JSON file
    $json = file_get_contents('data/articles.json');
    if ($json === false) {
        die('Error reading articles.json');
    }

    $articles = json_decode($json, true);
    if ($articles === null) {
        die('Error decoding articles.json');
    }

    // Find the index of the article to update
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

    // Update the article with new values
    $articles[$articleIndex]['title'] = $title;
    $articles[$articleIndex]['link'] = $link;
    $articles[$articleIndex]['updatedAt'] = date('l jS \of F Y, h:i A'); // Add the update date and time

    // Save updated articles to JSON file
    $success = file_put_contents('data/articles.json', json_encode($articles));
    if ($success === false) {
        die('Error writing articles.json');
    }

    // Redirect to index.php after updating
    header('Location: index.php');
    exit();
} else {
    die('Invalid request');
}
?>