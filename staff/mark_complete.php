<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $task_id = isset($_POST['task_id']) ? intval($_POST['task_id']) : 0;

    if ($task_id > 0) {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("UPDATE housekeeping_tasks SET status = 'completed' WHERE id = ?");
        $stmt->bind_param("i", $task_id);
        $success = $stmt->execute();
        
        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false]);
    }
}

$conn->close();
?>
