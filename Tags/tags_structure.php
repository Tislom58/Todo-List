<?php global $conn, $description, $color, $id; ?>

<!-- HTML structure for displaying tags -->

<br>
<div id='tagblock' class="taskblock">
    <div class='taskline'>
        <br>
        <div id=<?php echo $id;?> class='taskline'>
            <?php echo "<h4 style='color: $color;'>$description</h4>"; ?>
            <button class='button' onclick="updateTag(this.parentNode, this.parentNode.parentNode, this.parentNode.id)">Edit</button>
        </div>

        <form action='tagspage.php' method='POST' id='removetag'>
            <input type='hidden' name='id' value=<?php echo $id;?>>
            <input type='hidden' name='action' value='deletetag'>
            <input class='button' type='submit' value='Delete'>
        </form>
        <br>
    </div>
</div>
<br>

