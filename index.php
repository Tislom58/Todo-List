<!-- Establish connection with DB -->
<?php
global $conn;
require 'connect.php';
require 'server_requests.php';
require 'functions.php';
?>

<!-- TODO: Moznost pridat/odobrat tag pri editovani ulohy -->
<!-- TODO: Filter tagov -->

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

<h1 id="greet">Hi Daniel, what are your tasks today?</h1>

<div id="struct">
    <div>
        <div id="inputform" class="inputform">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                Add task: <label><input type="text" name="task"></label>
                <label for="due_date">Due date:</label>
                <input type="date" id="due_date" name="due_date">
                <input class="button" type="submit">
                <br><br>
                <div id="tagselect">
                    <label for="tags">Choose a tag: </label>
                    <select id="tags" name="tags[]">
                        <?php require 'tags.php'; ?>
                    </select>
                </div>
            </form>
            <button class="button" id="plusbutton" onclick="inputTag()"> + </button>
        </div>

        <div id="tasks">
            <?php require 'display_tasks.php'?>
        </div>
    </div>
</div>

</body>
<script type="text/javascript" src="index.js"></script>
</html>

<!-- close connection-->
<?php $conn->close(); ?>
