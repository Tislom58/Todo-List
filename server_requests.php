<?php
global $conn;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['due_date']) && isset($_POST['task'])) {
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

            $num_of_tags = count($_POST['tags']);
            for($i=0; $i<$num_of_tags; $i++) {

                $tag = $_POST['tags'][$i];
                if ($tag === "None") continue;

                $sql = "SELECT MAX(task_id) as max_id from Tasks";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $task_id = $row['max_id'];

                $stmtGetId = $conn->prepare("SELECT ID FROM Tags WHERE description=?");
                $stmtGetId->bind_param("s", $tag);
                $stmtGetId->execute();
                $result = $stmtGetId->get_result();
                $row = $result->fetch_assoc();
                $tag_id = $row['ID'];
                $stmtGetId->close();

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

                if ($is_duplicate) continue;

                $stmtLinkTags = $conn->prepare("INSERT INTO TasksTags (task_id, tag_id) VALUES (?, ?)");
                $stmtLinkTags->bind_param("ii", $task_id, $tag_id);
                $stmtLinkTags->execute();
                $stmtLinkTags->close();
            }
        } else {
            echo "<alert class='required'>No description!</alert>";
            $stmtInsertTask->close();
        }
    }
    if (isset($_POST['tag']) && isset($_POST['tagcolor'])) {
        $stmt = $conn->prepare("INSERT INTO Tags (description, color) VALUES (?, ?)");
        $stmt->bind_param("ss", $str, $tagcolor);

        if ($_POST['tag'] !== "") {
            $str = $_POST['tag'];
            $str = preg_replace('/[^a-zA-Z0-9_ %\[\].()&-]/', '', $str);
        } else {
            echo "<alert class='required'>No description!</alert>";
        }

        if ($_POST['tagcolor'] !== "") {
            $tagcolor = $_POST['tagcolor'];
            $tagcolor = preg_replace('/[^a-zA-Z0-9_ %\[\].()&-]/', '', $tagcolor);
        } else {
            $tagcolor = null;
        }

        $stmt->execute();
        $stmt->close();
    }
    if(isset($_POST['action'])) {
        if ($_POST['action'] === 'delete' || $_POST['action'] === 'complete') {
            if ($_POST['action'] === 'complete') {
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

            $sql = "DELETE FROM Tasks WHERE task_id=" . $_POST['id'];
            $conn->query($sql);

            $sql = "DELETE FROM TasksTags WHERE task_id=".$_POST['id'];
            $conn->query($sql);

        } elseif ($_POST['action'] === 'update') {
            $stmt = $conn->prepare("UPDATE Tasks SET task_description = ? WHERE task_id = ?");
            $stmt->bind_param("si", $description, $id);

            $id = $_POST['id'];
            $description = $_POST['desc'];

            $stmt->execute();
            $stmt->close();
        }
        if ($_POST['action'] === 'deletetag') {
            $sql = "DELETE FROM Tags WHERE ID=".$_POST['id'];
            $conn->query($sql);

            $sql = "DELETE FROM TasksTags WHERE tag_id=".$_POST['id'];
            $conn->query($sql);
        }
        elseif ($_POST['action'] === 'updatetag') {
            $stmt = $conn->prepare("UPDATE Tags SET description = ? WHERE ID = ?");
            $stmt->bind_param("si", $description, $id);

            $id = $_POST['id'];
            $description = $_POST['desc'];

            $stmt->execute();
            $stmt->close();
        }
    }
}
