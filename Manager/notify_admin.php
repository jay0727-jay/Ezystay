<?php
include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message = $_POST['message'];

    $query = "INSERT INTO notifications (message, seen) VALUES ('$message', 0)";
    if (!mysqli_query($conn, $query)) {
        die("Error sending notification: " . mysqli_error($conn));
    }
}
?>
