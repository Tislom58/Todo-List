<?php
global $conn;

// SQL query for displaying tags

$sql = "SELECT * FROM Tags";
$result = $conn->query($sql);

$rows = $result->fetch_all(MYSQLI_ASSOC);

echo "<h3>List of tags: </h3>";

if (!empty($rows)) {
    for ($i = 0; $i < count($rows); $i++) {
        $description = $rows[$i]['description'];
        $color = $rows[$i]['color'];
        $id = $rows[$i]['ID'];

        require 'tags_structure.php';
    }
}


