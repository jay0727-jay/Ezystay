
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Housekeeping Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"], input[type="number"], select {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #5cb85c;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .status-completed {
            color: green;
        }
        .status-pending {
            color: red;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Housekeeping Management</h1>
    
    <form action="housekeeping_with_knn_and_html.php" method="POST">
        <input type="hidden" name="task_id" value="">
        <label for="task_description">Task Description</label>
        <input type="text" name="task_description" id="task_description" required>
        
        <label for="room_number">Room Number</label>
        <input type="number" name="room_number" id="room_number" required>
        
        <label for="complexity">Complexity</label>
        <input type="number" name="complexity" id="complexity" min="1" max="5" required>
        
        <input type="submit" name="submit" value="Add Task">
    </form>

    <h2>Task List</h2>
    <table>
        <tr>
            <th>Task</th>
            <th>Room Number</th>
            <th>Complexity</th>
            <th>Prediction (On-Time Completion)</th>
            <th>Actions</th>
        </tr>
        <?php
        // Fetch tasks from the database
        include '../config.php';

        $result = mysqli_query($conn, "SELECT * FROM housekeeping_tasks");
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['task']}</td>";
            echo "<td>{$row['room_number']}</td>";
            echo "<td>{$row['complexity']}</td>";
            echo "<td>" . ($row['will_complete_on_time'] ? 'Yes' : 'No') . "</td>";
            echo "<td>";
            echo "<form action='housekeeping_with_knn_and_html.php' method='POST' style='display:inline;'>";
            echo "<input type='hidden' name='delete_id' value='{$row['id']}'>";
            echo "<input type='submit' name='delete' value='Delete'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>

</body>
</html>

<?php
include '../config.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['usermail']) || empty($_SESSION['usermail'])) {
    header("Location: http://localhost/hotelmanage_system/index.php");
    exit();
}
//machine learning 
// Define a simple dataset (historical data for KNN)

    $historical_tasks = [
        ['complexity' => 3, 'room_number' => 102, 'completed_on_time' => 0],
        ['complexity' => 3, 'room_number' => 104, 'completed_on_time' => 0],
        ['complexity' => 3, 'room_number' => 105, 'completed_on_time' => 0],
        ['complexity' => 1, 'room_number' => 101, 'completed_on_time' => 1],
        ['complexity' => 2, 'room_number' => 103, 'completed_on_time' => 1],
    ];
    


// Calculate Euclidean distance
function euclidean_distance($task1, $task2) {
    return sqrt(pow($task1['complexity'] - $task2['complexity'], 2) +
                pow($task1['room_number'] - $task2['room_number'], 2));
}

// K-Nearest Neighbors algorithm
function knn_predict($new_task, $historical_tasks, $k = 3) {
    $distances = [];
    
    foreach ($historical_tasks as $task) {
        $distance = euclidean_distance($new_task, $task);
        $distances[] = ['distance' => $distance, 'completed_on_time' => $task['completed_on_time']];
    }
    
    // Sort distances ascending
    usort($distances, function($a, $b) {
        return $a['distance'] <=> $b['distance'];
    });
    
    // Get the first k elements
    $nearest_neighbors = array_slice($distances, 0, $k);
    
    // Predict based on majority vote
    $votes = array_column($nearest_neighbors, 'completed_on_time');
    $prediction = array_sum($votes) > ($k / 2) ? 1 : 0;
    
    return $prediction;
}

// Handle form submission
if (isset($_POST['submit'])) {
    $id = $_POST['task_id'];
    $task = $_POST['task_description'];
    $room_number = (int)$_POST['room_number'];
    $complexity = (int)$_POST['complexity'];  // Assuming complexity is provided in the form

    $new_task = ['complexity' => $complexity, 'room_number' => $room_number];
    
    // Predict if the task will be completed on time
    $will_complete_on_time = knn_predict($new_task, $historical_tasks);
    
    if ($id) {
        // Update existing task
        $query = "UPDATE housekeeping_tasks SET task='$task', room_number='$room_number', will_complete_on_time='$will_complete_on_time' WHERE id=$id";
        if (!mysqli_query($conn, $query)) {
            die("Error updating task: " . mysqli_error($conn));
        }
    } else {
        // Add new task
        $query = "INSERT INTO housekeeping_tasks (task, room_number, will_complete_on_time) VALUES ('$task', '$room_number', '$will_complete_on_time')";
        if (!mysqli_query($conn, $query)) {
            die("Error adding task: " . mysqli_error($conn));
        }
    }

    echo "<script>notifyAdmin('A new housekeeping task has been added/updated.');</script>";
    header('Location: housekeeping_with_knn_and_html.php');
    exit();
}

// Handle task deletion
if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];
    $query = "DELETE FROM housekeeping_tasks WHERE id=$id";
    if (!mysqli_query($conn, $query)) {
        die("Error deleting task: " . mysqli_error($conn));
    }
    echo "<script>notifyAdmin('A housekeeping task has been deleted.');</script>";
    header('Location: housekeeping_with_knn_and_html.php');
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

    header('Location: housekeeping_with_knn_and_html.php');
    exit();
}
?>
