<!-- Establish connection with DB -->
<?php
global $conn;
require 'connect.php';
require 'server_requests.php';
require 'functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dančilist</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<header style="display: flex;">
    <a href="index.php"><button class="button" id="headerbutton">Tasks</button></a>
    <a href="tagspage.php"><button class="button" id="headerbutton">Tags</button></a>
    <a href="archivedtasks_page.php"><button class="button" id="headerbutton">Archived Tasks</button></a>
    <h3 style="margin: 10px;">
        Tasks done:
        <?php echo get_done_tasks($conn); ?>
    </h3>
</header>
<body>

<div id="struct">
    <div id="tags">
        <div class="inputform">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                Add tag: <label><input type="text" name="tag"></label>
                Choose color: <label><input type="text" name="tagcolor"></label>
                <input class="button" type="submit">
            </form>
        </div>
        <?php require 'display_tags.php'; ?>
    </div>
</div>

</body>
<script type="text/javascript" src="index.js"></script>
</html>

<!-- close connection-->
<?php $conn->close(); ?>
