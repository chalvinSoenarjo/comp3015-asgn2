<!DOCTYPE html>
<html>
<head>
    <title>Edit Article</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $json = file_get_contents('data/articles.json');
    if ($json === false) {
        die('Error reading articles.json');
    }
    $articles = json_decode($json, true);
    if ($articles === null) {
        die('Error decoding articles.json');
    }

    // Find the article by ID
    $article = null;
    foreach ($articles as $article) {
        if ($article['id'] == $id) {
            break;
        }
    }

    if ($article === null) {
        die('Article not found');
    }

    // Display the form for editing the article
    ?>
    <div class="container">
        <h1>Edit Article</h1>
        <form action="update_article.php" method="post">
            <input type="hidden" name="id" value="<?= $article['id'] ?>">
            <label for="edit_title">Edit Title:</label>
            <input type="text" id="edit_title" name="title" value="<?= $article['title'] ?>" required><br>
            <label for="edit_link">Edit Link:</label>
            <input type="url" id="edit_link" name="link" value="<?= $article['link'] ?>" required><br>
            <input type="submit" value="Save">
        </form>
    </div>
    <?php
} else {
    die('Invalid request');
}
?>
</body>
</html>
