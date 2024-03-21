<?php

function get_done_tasks($conn): int {
    $sql = "SELECT COUNT(*) AS total_rows FROM ArchivedTasks";
    $result = $conn->query($sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total_rows'];
}
