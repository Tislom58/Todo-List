<?php
global $conn;

// File containing all server requests

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Adding task
    if (isset($_POST['task'])) {
        $stmtInsertTask = $conn->prepare("INSERT INTO Tasks (task_description, due_date) VALUES (?, ?)");
        $stmtInsertTask->bind_param("ss", $task_description, $due_date);

        ($_POST['due_date'] !== "") ? $date = $_POST['due_date'] : $date = null;

        if ($_POST['task'] !== "") {
            $str = $_POST['task'];
            $str = preg_replace('/[^a-zA-Z0-9_ %\[\].()&-]/', '', $str);
            $task_description = $str;
            $due_date = $date;
            $stmtInsertTask->execute();
            $stmtInsertTask->close();

            // Add tags to the task
            $num_of_tags = count($_POST['tags']);
            for ($i = 0; $i < $num_of_tags; $i++) {

                $tag = $_POST['tags'][$i];
                if ($tag === "None") continue;  // Ignore "None" tags

                $sql = "SELECT MAX(task_id) as max_id from Tasks";  // Get the latest task ID
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $task_id = $row['max_id'];

                $stmtGetId = $conn->prepare("SELECT ID FROM Tags WHERE description=?");  // Get the ID of tag
                $stmtGetId->bind_param("s", $tag);
                $stmtGetId->execute();
                $result = $stmtGetId->get_result();
                $row = $result->fetch_assoc();
                $tag_id = $row['ID'];
                $stmtGetId->close();

                // Check if the same tag isn't put in multiple times
                $sql = "SELECT * FROM TasksTags";
                $result = $conn->query($sql);

                $is_duplicate = false;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row['tag_id'] == $tag_id && $row['task_id'] == $task_id) {
                            $is_duplicate = true;
                            break;
                        }
                    }
                }

                if ($is_duplicate) continue;  // Ignore tag if it was duplicated

                // Proceed with query
                $stmtLinkTags = $conn->prepare("INSERT INTO TasksTags (task_id, tag_id) VALUES (?, ?)");
                $stmtLinkTags->bind_param("ii", $task_id, $tag_id);
                $stmtLinkTags->execute();
                $stmtLinkTags->close();
            }
        } else {
            echo "<p class='required'>No description!</p>";
            $stmtInsertTask->close();
        }
    }
    if (isset($_POST['tag'])) {
        // Request adding a tag
        $stmt = $conn->prepare("INSERT INTO Tags (description, color) VALUES (?, ?)");
        $stmt->bind_param("ss", $str, $tagcolor);

        if ($_POST['tag'] !== "") {
            $str = $_POST['tag'];
            $str = preg_replace('/[^a-zA-Z0-9_ %\[\].()&-]/', '', $str);
        } else {
            echo "<p class='required'>No description!</p>";
        }

        // Set color of tag
        if ($_POST['tagcolor'] !== "") {
            $tagcolor = $_POST['tagcolor'];
            $tagcolor = preg_replace('/[^a-zA-Z0-9_ %\[\].()&-]/', '', $tagcolor);
        } else {
            $tagcolor = null;
        }

        $stmt->execute();
        $stmt->close();
    }
    if (isset($_POST['action'])) {
        // Request change
        if ($_POST['action'] === 'delete' || $_POST['action'] === 'complete') {
            if ($_POST['action'] === 'complete') {
                // Mark task as complete
                $stmt = $conn->prepare("INSERT INTO ArchivedTasks (task_description, due_date) VALUES (?, ?)");
                $stmt->bind_param("ss", $description, $due_date);

                $sql = "SELECT * FROM Tasks WHERE task_id=" . $_POST['id'];
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();

                $description = $row['task_description'];
                $due_date = $row['due_date'];

                $stmt->execute();
                $stmt->close();
            }

            // Delete task
            $sql = "DELETE FROM Tasks WHERE task_id=" . $_POST['id'];
            $conn->query($sql);

            $sql = "DELETE FROM TasksTags WHERE task_id=" . $_POST['id'];
            $conn->query($sql);

        } elseif ($_POST['action'] === 'update') {
            // Update task's description, due date and tags
            $stmt = $conn->prepare("UPDATE Tasks SET task_description = ?, due_date = ? WHERE task_id = ?");
            $stmt->bind_param("ssi", $description, $due_date, $id);

            $id = $_POST['id'];
            $sanitized_input = preg_replace('/[^a-zA-Z0-9_ %\[\].()&-]/', '', $_POST['desc']);
            $description = $sanitized_input;

            ($_POST['duedate'] !== "") ? $date = $_POST['duedate'] : $date = null;
            $due_date = $date;

            $stmt->execute();
            $stmt->close();

            $sql = "DELETE FROM TasksTags WHERE task_id=" . $id;
            $conn->query($sql);

            // Process tags request
            $num_of_tags = count($_POST['tags']);
            for ($i = 0; $i < $num_of_tags; $i++) {

                $tag = $_POST['tags'][$i];
                if ($tag === "None") continue;

                // Get tag ID
                $stmtGetId = $conn->prepare("SELECT ID FROM Tags WHERE description=?");
                $stmtGetId->bind_param("s", $tag);
                $stmtGetId->execute();
                $result = $stmtGetId->get_result();
                $row = $result->fetch_assoc();
                $tag_id = $row['ID'];
                $stmtGetId->close();

                // Check for duplicate
                $sql = "SELECT * FROM TasksTags";
                $result = $conn->query($sql);

                $is_duplicate = false;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row['tag_id'] == $tag_id && $row['task_id'] == $id) {
                            $is_duplicate = true;
                            break;
                        }
                    }
                }

                if ($is_duplicate) continue;

                // Proceed with query
                $stmtLinkTags = $conn->prepare("INSERT INTO TasksTags (task_id, tag_id) VALUES (?, ?)");
                $stmtLinkTags->bind_param("ii", $id, $tag_id);
                $stmtLinkTags->execute();
                $stmtLinkTags->close();
            }
        }
        if ($_POST['action'] === 'deletetag') {
            // Request tag deletion
            $sql = "DELETE FROM Tags WHERE ID=" . $_POST['id'];
            $conn->query($sql);

            $sql = "DELETE FROM TasksTags WHERE tag_id=" . $_POST['id'];
            $conn->query($sql);
        } elseif ($_POST['action'] === 'updatetag') {
            // Request tag description change
            $stmt = $conn->prepare("UPDATE Tags SET description = ? WHERE ID = ?");
            $stmt->bind_param("si", $description, $id);

            $id = $_POST['id'];
            $sanitized_input = preg_replace('/[^a-zA-Z0-9_ %\[\].()&-]/', '', $_POST['desc']);
            $description = $sanitized_input;

            $stmt->execute();
            $stmt->close();
        }
    }
}
