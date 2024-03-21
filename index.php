<!-- Establish connection with DB -->
<?php
global $conn;
require 'connect.php';
require 'server_requests.php';
require 'functions.php';
?>

<!-- TODO: Moznost pridat/odobrat tag pri editovani ulohy -->
<!-- TODO: Filter tagov -->
<!-- TODO: Moznost editovat deadline pri editovani ulohy -->

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dančilist</title>
    <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<header>
    <h3>
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
                <input type="submit">
                <br><br>
                <div id="tagselect">
                    <label for="tags">Choose a tag: </label>
                    <select id="tags" name="tags[]">
                        <?php require 'tags.php'; ?>
                    </select>
                </div>
            </form>
            <button onclick="inputTag()" style="display: inline">+</button>
        </div>

        <div id="tasks">
            <?php require 'display_tasks.php'?>
        </div>
    </div>

    <div id="tags">
        <div class="inputform">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                Add tag: <label><input type="text" name="tag"></label>
                Choose color: <label><input type="text" name="tagcolor"></label>
                <input type="submit">
            </form>
        </div>
        <?php require 'display_tags.php'; ?>
    </div>
</div>

</body>
<script>
</script>
</html>

<!-- close connection-->
<?php $conn->close(); ?>
