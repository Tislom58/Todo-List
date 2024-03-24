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
<header style="display: flex; margin-bottom: 50px;">
    <a href="index.php"><button class="button" id="headerbutton">Tasks</button></a>
    <a href="tagspage.php"><button class="button" id="headerbutton">Tags</button></a>
    <a href="archivedtasks_page.php"><button class="button" id="headerbutton">Archived Tasks</button></a>
    <h3 style="margin: 10px;">
        Tasks done:
        <?php echo get_done_tasks($conn); ?>
    </h3>
</header>
<body>

<div id="tasks">
    <?php require 'display_archived_tasks.php'?>
</div>

</body>
<script type="text/javascript" src="index.js"></script>
</html>

<!-- close connection-->
<?php $conn->close(); ?>

