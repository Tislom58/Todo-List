<!-- Establish connection with DB -->
<?php
global $conn;
require '../Index/connect.php';
require '../Index/server_requests.php';
require '../Index/functions.php';
?>

<!-- Page with tags -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dančilist</title>
    <link rel="stylesheet" type="text/css" href="../Index/styles.css" />
</head>

<!-- Link other pages -->
<header style="display: flex;">
    <a href="../Index/index.php"><button class="button" id="headerbutton">Tasks</button></a>
    <a href="tagspage.php"><button class="button" id="headerbutton">Tags</button></a>
    <a href="../ArchivedTasks/archivedtasks_page.php"><button class="button" id="headerbutton">Archived Tasks</button></a>
    <h3 style="margin: 10px;">
        Tasks done:
        <?php echo get_done_tasks($conn); ?>
    </h3>
</header>
<body>

<!-- Block of displayed tags -->
<div id="struct">
    <div id="tags">
        <div class="inputform">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                Add tag: <label><input type="text" name="tag"></label>
                Choose color: <label><input type="text" name="tagcolor"></label>
                <input class="button" type="submit" value="Add tag">
            </form>
        </div>
        <?php require 'display_tags.php'; ?>
    </div>
</div>

</body>

<!-- Include JS -->
<script type="text/javascript" src="../Index/index.js"></script>
</html>

<!-- close connection-->
<?php $conn->close(); ?>
