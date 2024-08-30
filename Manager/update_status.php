<?php
include '../config.php'; // Ensure this file is correctly included

$message = '';
$notificationClass = 'notification'; // Default to hide the notification box

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['feedback_id'], $_POST['assigned_staff_id'], $_POST['issue_description'])) {
        $feedback_id = $_POST['feedback_id'];
        $assigned_staff_id = $_POST['assigned_staff_id'];
        $issue_description = $_POST['issue_description'];

        $sql = "UPDATE feedback SET status = 'resolved' WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $message = "Prepare failed: " . $conn->error;
            $notificationClass = 'notification error';
        } else {
            $stmt->bind_param('i', $feedback_id);

            if ($stmt->execute()) {
                $message = "Status updated successfully!";
                $notificationClass = 'notification success';
            } else {
                $message = "Error updating status: " . $stmt->error;
                $notificationClass = 'notification error';
            }

            $stmt->close();
        }
    } else {
        $message = "Required fields are missing.";
        $notificationClass = 'notification error';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Status</title>
    <style>
        /* Style for the form container */
        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #f9f9f9;
        }

        /* Style for form labels */
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        /* Style for text input fields */
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        /* Style for textarea */
        textarea {
            height: 150px;
            resize: vertical;
        }

        /* Style for the submit button */
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        /* Hover effect for the button */
        button:hover {
            background-color: #0056b3;
        }

        /* Style for the notification box */
        .notification {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px;
            color: white;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .notification.success {
            background-color: #4CAF50; /* Green for success */
        }

        .notification.error {
            background-color: #f44336; /* Red for error */
        }
    </style>
</head>
<body>
    <form id="statusForm" action="" method="post">
        <input type="hidden" name="feedback_id" value="1">
        <label for="assigned_staff_id">Assigned Staff ID:</label>
        <input type="text" name="assigned_staff_id" required>
        <label for="issue_description">Issue Description:</label>
        <textarea name="issue_description" required></textarea>
        <button type="submit">Generate Ticket</button>
    </form>
    
    <?php if ($message): ?>
    <div id="notification" class="<?php echo $notificationClass; ?>">
        <?php echo $message; ?>
    </div>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var notification = document.getElementById('notification');
            if (notification) {
                // Show the notification box for 3 seconds
                setTimeout(function() {
                    notification.style.display = 'block';
                }, 100); // Short delay to ensure visibility

                setTimeout(function() {
                    notification.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</body>
</html>
