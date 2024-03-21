<?php
global $conn;

$sql = "SELECT * FROM Tags";
$result = $conn->query($sql);

$rows = $result->fetch_all(MYSQLI_ASSOC);

echo "<option>None</option>";

if (!empty($rows)) {
    for ($i = 0; $i < count($rows); $i++) {
        $description = $rows[$i]['description'];
        echo "<option>$description</option>";
    }
}
