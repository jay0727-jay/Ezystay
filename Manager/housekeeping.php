<?php
include '../config.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['usermail']) || empty($_SESSION['usermail'])) {
    header("Location: http://localhost/hotelmanage_system/index.php");
    exit();
}

// Handle form submission
if (isset($_POST['submit'])) {
    $id = $_POST['task_id'];
    $task = $_POST['task_description'];
    $room_number = $_POST['room_number'];

    if ($id) {
        // Update existing task
        $query = "UPDATE housekeeping_tasks SET task='$task', room_number='$room_number' WHERE id=$id";
        if (!mysqli_query($conn, $query)) {
            die("Error updating task: " . mysqli_error($conn));
        }
    } else {
        // Add new task
        $query = "INSERT INTO housekeeping_tasks (task, room_number) VALUES ('$task', '$room_number')";
        if (!mysqli_query($conn, $query)) {
            die("Error adding task: " . mysqli_error($conn));
        }
    }

    // Notify admin via AJAX
    echo "<script>notifyAdmin('A new housekeeping task has been added/updated.');</script>";
    header('Location: housekeeping.php');
    exit();
}

// Handle task deletion
if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];
    $query = "DELETE FROM housekeeping_tasks WHERE id=$id";
    if (!mysqli_query($conn, $query)) {
        die("Error deleting task: " . mysqli_error($conn));
    }
    // Notify admin via AJAX
    echo "<script>notifyAdmin('A housekeeping task has been deleted.');</script>";
    header('Location: housekeeping.php');
    exit();
}

// Handle task status update
if (isset($_POST['update_status'])) {
    $id = $_POST['task_id'];
    $status = $_POST['status'];

    if ($status == 'completed') {
        $query = "UPDATE housekeeping_tasks SET status='$status', completed_at=NOW() WHERE id=$id";
    } else {
        $query = "UPDATE housekeeping_tasks SET status='$status' WHERE id=$id";
    }

    if (!mysqli_query($conn, $query)) {
        die("Error updating status: " . mysqli_error($conn));
    }
    // Notify admin via AJAX
    echo "<script>notifyAdmin('A housekeeping task status has been updated.');</script>";
    header('Location: housekeeping.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housekeeping Admin Panel</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        /* General Container */
.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

/* Header */
h1 {
    text-align: center;
    color: #343a40;
    margin-bottom: 30px;
}

/* Form Styles */
.task-form {
    display: flex;
    gap: 10px;
    margin-bottom: 20px;
}

.task-form input,
.task-form button {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ced4da;
    border-radius: 5px;
}

.task-form input {
    flex: 1;
}

.task-form button {
    background-color: #007bff;
    color: #fff;
    border: none;
    transition: background-color 0.3s;
    cursor: pointer;
}

.task-form button:hover {
    background-color: #0056b3;
}

/* Table Styles */
.task-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.task-table th,
.task-table td {
    border: 1px solid #dee2e6;
    padding: 12px;
    text-align: left;
}

.task-table th {
    background-color: #343a40;
    color: #fff;
    text-transform: uppercase;
    font-weight: bold;
}

.task-table td {
    background-color: #fff;
}

.task-table tr:nth-child(even) td {
    background-color: #f2f2f2;
}

/* Button Styles */
.task-table td button,
.task-table td select {
    padding: 6px 12px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.task-table td form {
    display: inline;
}

.task-table td select {
    padding: 5px;
    border: 1px solid #ced4da;
    background-color: #fff;
    color: #495057;
}

.task-table td button.edit-btn {
    background-color: #ffc107;
    color: #212529;
    border: none;
}

.task-table td button.edit-btn:hover {
    background-color: #e0a800;
}

.task-table td button.delete-btn {
    background-color: #dc3545;
    color: #fff;
    border: none;
}

.task-table td button.delete-btn:hover {
    background-color: #c82333;
}

.task-table td button.complete-btn {
    background-color: #28a745;
    color: #fff;
    border: none;
}

.task-table td button.complete-btn:hover {
    background-color: #218838;
}

/* Responsive Design */
@media (max-width: 768px) {
    .task-form {
        flex-direction: column;
        gap: 0;
    }

    .task-form input,
    .task-form button {
        width: 100%;
        margin-bottom: 10px;
    }

    .task-table th,
    .task-table td {
        font-size: 14px;
        padding: 8px;
    }

    .task-table td button,
    .task-table td select {
        font-size: 12px;
        padding: 4px 8px;
    }
}

    </style>
</head>
<body>
    <div class="container">
        <h1>Housekeeping Management</h1>
        <form action="housekeeping.php" method="post" class="task-form">
            <input type="hidden" name="task_id" class="task-id">
            <input type="text" name="task_description" class="task-description" placeholder="Enter task" required>
            <input type="number" name="room_number" class="room-number" placeholder="Enter room number" required>
            <button type="submit" name="submit" class="btn">Add/Update Task</button>
        </form>
        <table class="task-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Task</th>
                    <th>Room Number</th>
                    <th>Status</th>
                    <th>Assigned At</th>
                    <th>Completed At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM housekeeping_tasks";
                $result = mysqli_query($conn, $query);

                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['task'] . "</td>";
                        echo "<td>" . $row['room_number'] . "</td>";
                        echo "<td>" . ucfirst($row['status']) . "</td>";
                        echo "<td>" . ($row['completed_at'] ? $row['completed_at'] : 'N/A') . "</td>";
                        echo "<td>";
                        echo "<button onclick=\"editTask(" . $row['id'] . ", '" . $row['task'] . "', " . $row['room_number'] . ")\" class='btn edit-btn'>Edit</button>";
                        echo "<form action='housekeeping.php' method='post' style='display:inline;'>";
                        echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
                        echo "<button type='submit' name='delete' class='btn delete-btn'>Delete</button>";
                        echo "</form>";
                        echo "<form action='housekeeping.php' method='post' style='display:inline;'>";
                        echo "<input type='hidden' name='task_id' value='" . $row['id'] . "'>";
                        echo "<select name='status' onchange='this.form.submit()'>";
                        echo "<option value='pending'" . ($row['status'] == 'pending' ? ' selected' : '') . ">Pending</option>";
                        echo "<option value='in_progress'" . ($row['status'] == 'in_progress' ? ' selected' : '') . ">In Progress</option>";
                        echo "<option value='completed'" . ($row['status'] == 'completed' ? ' selected' : '') . ">Completed</option>";
                        echo "</select>";
                        echo "<input type='hidden' name='update_status' value='1'>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Error retrieving tasks: " . mysqli_error($conn) . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function editTask(id, task, roomNumber) {
            document.querySelector('.task-id').value = id;
            document.querySelector('.task-description').value = task;
            document.querySelector('.room-number').value = roomNumber;
            document.querySelector('.task-form button').textContent = 'Update Task';
        }

        // Function to notify admin via AJAX
        function notifyAdmin(message) {
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "notify_admin.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhr.send("message=" + encodeURIComponent(message));
        }
    </script>
</body>
</html>
