    <!DOCTYPE html>
    <html>
    <head>
        <title>Submit Article</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <?php include 'navbar.php'; ?>
    
    <div class="container">
        <h1>Submit Article</h1>
        <form action="submit_article.php" method="post">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br>
            <label for="link">Link:</label>
            <input type="url" id="link" name="link" required><br>
            <input type="submit" value="Submit">
        </form>
    </div>
    </body>
    </html>
