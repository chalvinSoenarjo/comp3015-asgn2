<!DOCTYPE html>
<html>
<head>
    <title>News Aggregator</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
// Read the contents of the JSON file or initialize with an empty array if empty
$json = file_get_contents('data/articles.json');
if ($json === false || empty($json)) {
    $articles = [];
} else {
    // Decode the JSON string into an array
    $articles = json_decode($json, true);
    if ($articles === null) {
        die('Error decoding articles.json');
    }
}

// Include the navbar
include 'navbar.php';

// Handle search
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $searchTerm = $_GET['search'];
    // Filter articles based on search term
    $filteredArticles = array_filter($articles, function($article) use ($searchTerm) {
        return strpos(strtolower($article['title']), strtolower($searchTerm)) !== false
            || strpos(strtolower($article['link']), strtolower($searchTerm)) !== false;
    });
    $articles = $filteredArticles;
}

// Save updated articles to JSON file with pretty printing
$success = file_put_contents('data/articles.json', json_encode($articles, JSON_PRETTY_PRINT));
if ($success === false) {
    die('Error writing articles.json');
}
?>
<div class="container">
    <h1>Latest Articles</h1>
    <form action="index.php" method="get">
        <input type="text" name="search" placeholder="Search...">
        <input type="submit" value="Search">
    </form>
    <ul>
        <?php foreach ($articles as $article): ?>
            <li>
                <h2><?= $article['title'] ?></h2>
                <p>Article ID: <?= $article['id'] ?></p> <!-- Display ID here -->
                <p>Created at <?= $article['createdAt'] ?> <br> Userid: <?= $article['userId'] ?> <br> Posted by <?= $article['username'] ?></p><br><br>
                <?php if (isset($article['updatedAt'])): ?>
                    <p>Updated at <?= $article['updatedAt'] ?></p>
                <?php endif; ?>
                <a href="<?= $article['link'] ?>" target="_blank"><?= $article['link'] ?></a>
                <div class="article-actions">
                    <form action="edit_article.php" method="post">
                        <input type="hidden" name="id" value="<?= $article['id'] ?>">
                        <input type="submit" value="Edit">
                    </form>
                    <form action="delete_article.php" method="post">
                        <input type="hidden" name="id" value="<?= $article['id'] ?>">
                        <input type="submit" value="Delete">
                    </form>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
