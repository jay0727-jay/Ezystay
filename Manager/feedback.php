<?php
include '../config.php'; // Ensure this file is correctly included

// Function to call sentiment analysis API
function analyze_sentiment($comments) {
    $positive_words = ["good", "great", "excellent", "happy", "satisfied"];
    $negative_words = ["bad", "poor", "terrible", "unhappy", "dissatisfied"];

    $positive_score = 0;
    $negative_score = 0;

    $comments_lower = strtolower($comments);

    foreach ($positive_words as $word) {
        $positive_score += substr_count($comments_lower, $word);
    }

    foreach ($negative_words as $word) {
        $negative_score += substr_count($comments_lower, $word);
    }

    if ($positive_score > $negative_score) {
        $sentiment = "Positive";
    } elseif ($negative_score > $positive_score) {
        $sentiment = "Negative";
    } else {
        $sentiment = "Neutral";
    }

    echo "Sentiment Calculated: " . $sentiment; // Debugging statement
    return $sentiment;
}


// Function to save feedback and sentiment to the database
function save_feedback($guest_id, $rating, $comments, $category) {
    global $conn;

    $sentiment = analyze_sentiment($comments);
    echo "Saving Sentiment: " . $sentiment; // Debugging statement

    $feedback_date = date('Y-m-d H:i:s');
    $status = "Pending"; // Default status

    $stmt = $conn->prepare("INSERT INTO feedback (guest_id, feedback_date, rating, comments, category, sentiment, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("issssss", $guest_id, $feedback_date, $rating, $comments, $category, $sentiment, $status);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $stmt->close();
        return "Thank you for your feedback!";
    } else {
        $stmt->close();
        return "Failed to submit feedback. Please try again.";
    }
}


// Handling form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $guest_id = $_POST['guest_id'] ?? '';
    $rating = $_POST['rating'] ?? '';
    $comments = $_POST['comments'] ?? '';
    $category = $_POST['category'] ?? '';

    if (!empty($guest_id) && !empty($rating) && !empty($comments) && !empty($category)) {
        $message = save_feedback($guest_id, $rating, $comments, $category);
    } else {
        $message = "Please fill in all fields.";
    }

    echo $message;
}

// Fetch all feedback for display
$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);
if ($result === false) {
    die("Query failed: " . $conn->error);
}

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

        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .sentiment {
            font-weight: bold;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
        }

        .update-status-btn,
        .generate-ticket-btn {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .update-status-btn {
            background-color: #4CAF50;
            color: white;
        }

        .generate-ticket-btn {
            background-color: #007BFF;
            color: white;
        }

        .update-status-btn:hover,
        .generate-ticket-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Feedback Dashboard</h1>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Rating</th>
                    <th>Comments</th>
                    <th>Category</th>
                    <th>Sentiment</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['feedback_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['rating']); ?></td>
                    <td><?php echo htmlspecialchars($row['comments']); ?></td>
                    <td><?php echo htmlspecialchars($row['category']); ?></td>
                    <td class="sentiment"><?php echo htmlspecialchars($row['sentiment']); ?></td>
                    <td>
                        <form action="" method="post">
                            <select name="status" class="status-select">
                                <option value="Pending" <?php echo ($row['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="In Progress" <?php echo ($row['status'] == 'In Progress') ? 'selected' : ''; ?>>In Progress</option>
                                <option value="Resolved" <?php echo ($row['status'] == 'Resolved') ? 'selected' : ''; ?>>Resolved</option>
                            </select>
                            <input type="hidden" name="feedback_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <button type="submit" name="update_status" class="update-status-btn">Update Status</button>
                        </form>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <form action="generate_ticket.php" method="post">
                                <input type="hidden" name="feedback_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                <button type="submit" name="generate_ticket" class="generate-ticket-btn">Generate Ticket</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
