<?php
include '../config.php'; // Ensure this file is correctly included

// Initialize a success flag
$update_success = false;

// Handle the status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['feedback_id'], $_POST['status'])) {
    $feedback_id = $_POST['feedback_id'];
    $status = $_POST['status'];

    $update_sql = "UPDATE feedback SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $status, $feedback_id);

    if ($stmt->execute()) {
        // Set the success flag
        $update_success = true;
    } else {
        echo "Error updating status.";
    }

    $stmt->close();
}

// Fetch feedback data from the database
$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .dashboard-container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
        }

        .status-select {
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .update-status-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 5px;
        }

        .update-status-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Feedback Dashboard</h1>
        <table>
            <tr>
                <th>ID</th>
              
                <th>Rating</th>
                <th>Comments</th>
                <th>Category</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                
                <td><?php echo $row['rating']; ?></td>
                <td><?php echo $row['comments']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td>
                    <!-- Dropdown for status update -->
                    <form method="post" action="">
                        <input type="hidden" name="feedback_id" value="<?php echo $row['id']; ?>">
                        <select name="status" class="status-select">
                            <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="Completed" <?php if ($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                            <option value="In Progress" <?php if ($row['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                        </select>
                </td>
                <td>
                    <button type="submit" class="update-status-btn">Update Status</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>

    <?php if ($update_success): ?>
        <script>
            alert("Updated successfully");
        </script>
    <?php endif; ?>
</body>
</html>
