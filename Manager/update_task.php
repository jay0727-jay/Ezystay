<?php
include '../config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : 0;
    $task_category = isset($_POST['task_category']) ? trim($_POST['task_category']) : '';

    // Debugging output to check incoming data
    if ($task_id === 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid task ID: ' . $task_id]);
        exit;
    }

    if (empty($task_category)) {
        echo json_encode(['success' => false, 'message' => 'Invalid task category: ' . $task_category]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE tasks SET category = ? WHERE id = ?");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Error preparing the statement: ' . $conn->error]);
        exit;
    }

    $stmt->bind_param("si", $task_category, $task_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update task category: ' . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
