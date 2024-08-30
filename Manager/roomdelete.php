<?php
// Include the database connection file
include '../config.php'; // Replace with your actual database connection file

// Check if the reservation ID is provided
if (isset($_POST['reservation_id'])) {
    $reservation_id = $_POST['reservation_id'];

    // Update the reservation status to 'Cancelled'
    $query = "UPDATE reservations SET status = 'Cancelled' WHERE id = ?";
    $stmt = $connection->prepare($query);

    if ($stmt) {
        $stmt->bind_param('i', $reservation_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Reservation cancelled!";
        } else {
            echo "Error: Could not cancel reservation.";
        }

        $stmt->close();
    } else {
        echo "Error: Could not prepare statement.";
    }

    // Close the database connection
    $connection->close();
} else {
    echo "Error: Reservation ID not provided.";
}
?>
