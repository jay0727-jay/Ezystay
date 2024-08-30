<?php
include 'config.php'; // Database connection file


// Get feedback data from POST request
$guest_id = $_POST['guest_id'];
$rating = $_POST['rating'];
$comments = $_POST['comments'];
$category = $_POST['category'];

// Insert feedback into the database
$sql = "INSERT INTO feedback (guest_id, feedback_date, rating, comments, category, status) VALUES (?, NOW(), ?, ?, ?, 'new')";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iiss', $guest_id, $rating, $comments, $category);

if ($stmt->execute()) {
    echo "Feedback submitted successfully!";
} else {
    echo "Error submitting feedback: " . $conn->error;
}


$stmt->close();
$conn->close();
?>

