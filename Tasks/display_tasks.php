<?php
global $conn;

// SQL query for displaying tasks

if (!isset($_POST['select-filter'])) {
    // Display tasks without filter
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
} else
{
    // Display tasks with filter active
    $filtered_tags = $_POST['select-filter'];
    $tags = [];
    $tasks = [];
    $exclude_tasks = [];

    // Loop through selected tags
    foreach ($filtered_tags as $tag) {
        if ($tag === "None" and count($filtered_tags) === 1)
        {
            // Only selected option was "None"
            $sql = "SELECT task_id FROM TasksTags";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Find tasks that should be excluded
                    $exclude_tasks[] = $row['task_id'];
                }
            }
            // Display tasks except the excluded ones
            $sql = "SELECT * FROM Tasks";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $excluded = false;
                    $task_id = $row['task_id'];
                    foreach ($exclude_tasks as $exclude_task) {
                        if ($exclude_task === $task_id) {
                            $excluded = true;
                            break;
                        }
                    }
                    if ($excluded) {
                        continue;
                    }
                    $due_date = ($row["due_date"] ?? "Not specified");
                    $description = $row["task_description"];
                    $id = $row['task_id'];

                    require 'tasks_structure.php';
                }
            }
            break;
        } elseif ($tag === "None" and count($filtered_tags) !== 1)
        {
            // Ignore "None" tag if more than 1 option is selected
            continue;
        }
        $stmtGetId = $conn->prepare("SELECT ID FROM Tags WHERE description=?");
        $stmtGetId->bind_param("s", $tag);
        $stmtGetId->execute();
        $result = $stmtGetId->get_result();
        $row = $result->fetch_assoc();
        $tag_id = $row['ID'];
        $stmtGetId->close();
        $tags[] = $tag_id;
    }
    // Loop through tasks associated with the tags
    foreach ($tags as $tag_id) {
        $sql = "SELECT task_id FROM TasksTags WHERE tag_id =" . $tag_id;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tasks[] = $row['task_id'];
            }
        }
    }
    // Check for task duplicates - there should be as many duplicates as there are selected tasks, else they don't satisfy the filter
    $duplicates = array_count_values($tasks);
    foreach ($duplicates as $value => $occurances) {
        if ($occurances != count($tags)) {
            unset($duplicates[$value]);
        }
    }
    $tasks = [];  // Empty array
    // Fill again with filtered tasks
    foreach ($duplicates as $k => $v) {
        $tasks[] = $k;
    }
    // Display filtered tasks
    foreach ($tasks as $task_id) {
        $sql = "SELECT * FROM Tasks WHERE task_id=" . $task_id;
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $due_date = ($row["due_date"] ?? "Not specified");
        $description = $row["task_description"];
        $id = $task_id;

        require 'tasks_structure.php';
    }
}
