<?php global $conn, $description, $color, $id; ?>

<br>
<div id='tagblock' class="taskblock">
    <div class='taskline'>
        <br>
        <div id=<?php echo $id;?> class='taskline'>
            <?php echo "<h4 style='color: $color;'>$description</h4>"; ?>
            <button class='buttondone' onclick="updateTag(this.parentNode, this.parentNode.id)">Edit</button>
        </div>

        <form action='index.php' method='POST' id='removetag'>
            <input type='hidden' name='id' value=<?php echo $id;?>>
            <input type='hidden' name='action' value='deletetag'>
            <input class='buttondone' type='submit' value='Delete'>
        </form>
        <br>
    </div>
</div>
<br>
