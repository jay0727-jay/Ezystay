<?php
include '../config.php';

// Fetch the most recent unseen notification
$query = "SELECT * FROM notifications WHERE seen = 0 ORDER BY id DESC LIMIT 1";
$result = mysqli_query($conn, $query);

$notifications = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $notifications[] = $row;

        // Mark this notification as seen
        $updateQuery = "UPDATE notifications SET seen = 1 WHERE id = " . $row['id'];
        mysqli_query($conn, $updateQuery);
    }
}

echo json_encode($notifications);
?>
