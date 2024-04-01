<!-- Establish connection with DB -->
<?php
global $conn;
require '../Index/connect.php';
require '../Index/server_requests.php';
require '../Index/functions.php';
?>

<!-- Landing page for archived tasks -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dančilist</title>
    <link rel="stylesheet" type="text/css" href="../Index/styles.css" />
</head>

<!-- Link other pages -->
<header style="display: flex; margin-bottom: 50px;">
    <a href="../Index/index.php"><button class="button" id="headerbutton">Tasks</button></a>
    <a href="../Tags/tagspage.php"><button class="button" id="headerbutton">Tags</button></a>
    <a href="archivedtasks_page.php"><button class="button" id="headerbutton">Archived Tasks</button></a>
    <h3 style="margin: 10px;">
        Tasks done:
        <?php echo get_done_tasks($conn); ?>
    </h3>
</header>
<body>

<!-- Display archived tasks -->
<div id="tasks">
    <?php require 'display_archived_tasks.php' ?>
</div>

</body>

<!-- Include JS -->
<script type="text/javascript" src="../Index/index.js"></script>
</html>

<!-- close connection-->
<?php $conn->close(); ?>

