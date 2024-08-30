<?php
include '../config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_title = isset($_POST['task_title']) ? trim($_POST['task_title']) : '';
    $task_desc = isset($_POST['task_desc']) ? trim($_POST['task_desc']) : '';
    $task_category = 'todo'; // New tasks start in the 'todo' category

    if (!empty($task_title)) {
        $stmt = $conn->prepare("INSERT INTO tasks (title, description, category) VALUES (?, ?, ?)");
        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Error preparing the statement: ' . $conn->error]);
            exit;
        }

        $stmt->bind_param("sss", $task_title, $task_desc, $task_category);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'task_id' => $stmt->insert_id]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to insert task: ' . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Title is required.']);
    }
}

$conn->close();
?>
