<?php
// cancel_reservation.php
include 'config.php';
session_start();

// Initialize a variable for the status message
$statusMessage = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare the SQL statement to delete the reservation
    $sql = "DELETE FROM roombook WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the ID parameter to the SQL query
        $stmt->bind_param("i", $id);

        // Execute the query
        if ($stmt->execute()) {
            // Set success message if the deletion was successful
            $statusMessage = "Cancellation successful.";
        } else {
            // Set error message if the deletion fails
            $statusMessage = "Error: Could not execute the cancellation.";
        }
    } else {
        // Set error message if the preparation of the statement fails
        $statusMessage = "Error: Could not prepare the cancellation.";
    }

    // Close the statement
    $stmt->close();
} else {
    // Set message if no ID is provided
    $statusMessage = "No reservation ID provided.";
}
if(isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "UPDATE roombook SET status = 'Cancelled' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: view_reservations.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Reservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .message-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .message-container h2 {
            color: #4CAF50;
            margin-bottom: 20px;
        }

        .message-container p {
            font-size: 18px;
            color: #333;
        }

        .back-button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <h2><?php echo $statusMessage; ?></h2>
        <a href="reservation-view.php" class="back-button">Back to Reservations</a>
    </div>
</body>
</html>
