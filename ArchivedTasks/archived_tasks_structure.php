<?php global $conn, $description, $due_date, $id; ?>
<!-- HTML structure for archived tasks -->

<br>
<div class="taskblock">
    <div class='taskline'>
        <div id=<?php echo $id;?> class='taskline'>
            <br>
            <?php echo $description; ?>
        </div>
        <br>
    </div>
    <?php echo "Due: ".$due_date; ?>
</div>
<br>

