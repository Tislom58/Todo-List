<?php
global $conn;

$sql = "SELECT * FROM Tasks";
$result = $conn->query($sql);

$rows = $result->fetch_all(MYSQLI_ASSOC);

if (!empty($rows)) {
    for ($i = 0; $i < count($rows); $i++) {
        $due_date = ($rows[$i]["due_date"] ?? "Not specified");
        $description = $rows[$i]["task_description"];
        $id = $rows[$i]['task_id'];

        require 'tasks_structure.php';
    }
}
