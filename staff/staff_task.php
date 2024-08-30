<?php
// staff_tasks.php
include '../config.php';
session_start();


// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM housekeeping_tasks WHERE status = 'pending'");
$stmt->execute();
$result = $stmt->get_result();

// Check for query execution errors
if (!$result) {
    die('Error fetching tasks: ' . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Tasks</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        form {
            margin: 0;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        #message {
            margin: 20px 0;
            padding: 10px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
            display: none; /* Hidden by default */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').submit(function(event) {
                event.preventDefault(); // Prevent the default form submission

                var form = $(this);
                $.ajax({
                    type: 'POST',
                    url: form.attr('action'),
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#message').text('Task status updated successfully. Redirecting...').show();
                            setTimeout(function() {
                                window.location.href = 'dashboard.php'; // Redirect to the dashboard
                            }, 2000); // Delay for 2 seconds to show the message
                        } else {
                            $('#message').text('Failed to update task status.').show();
                        }
                    },
                    error: function() {
                        $('#message').text('An error occurred while updating the task status.').show();
                    }
                });
            });
        });
    </script>
</head>
<body>
    <h1>Pending Tasks</h1>
    <div id="message"></div>
    <table>
        <tr>
            <th>Task</th>
            <th>Action</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['task']) . '</td>'; // Assuming the column name is 'task'
            echo '<td><form method="POST" action="mark_complete.php">';
            echo '<input type="hidden" name="task_id" value="' . htmlspecialchars($row['id']) . '">';
            echo '<input type="submit" value="Mark as Complete">';
            echo '</form></td>';
            echo '</tr>';
        }
        ?>
    </table>
</body>
</html>

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
