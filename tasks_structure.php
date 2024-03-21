<?php global $conn, $description, $due_date, $id; ?>

<br>
<div class="taskblock">
    <div class='taskline'>
        <div id=<?php echo $id;?> class='taskline'>
            <br>
            <form action='index.php' method='POST' id='completetask'>
                <input type='hidden' name='id' value=<?php echo $id;?>>
                <input type='hidden' name='action' value='complete'>
                <input class='buttondone' type='submit' value='Done'>
            </form>
            <?php echo $description; ?>
            <button class='buttondone' onclick="updateTask(this.parentNode, this.parentNode.id)">Edit</button>
        </div>

        <form action='index.php' method='POST' id='removetag'>
            <input type='hidden' name='id' value=<?php echo $id;?>>
            <input type='hidden' name='action' value='delete'>
            <input class='buttondone' type='submit' value='Delete'>
        </form>
        <br>
    </div>
    <?php echo "Due: ".$due_date; ?>
    <div id="tagsintasks">
    <?php
    $sql = "SELECT tag_id FROM TasksTags WHERE task_id=".$id;
    $result = $conn->query($sql);

    $tag_ids = [];

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            $tag_ids[] = $row['tag_id'];
        }
    }

    foreach ($tag_ids as $x) {
        $sql = "SELECT * FROM Tags WHERE ID=".$x;
        $reult = $conn->query($sql);
        $rowTag = $reult->fetch_assoc();
        $desc = $rowTag['description'];
        $color = $rowTag['color'];

        echo "<p style='color: $color; margin: 5px;'>$desc</p>";
    }
    ?>
    </div>
</div>
<br>

