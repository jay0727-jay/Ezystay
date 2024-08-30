<?php
// Connect to the database
include 'config.php';
session_start();

if (isset($_POST['check_status'])) {
    $email = $_POST['email'];
    $reservation_id = $_POST['reservation_id'];

    // Prepare the SQL query to fetch the reservation status
    $sql = "SELECT stat, cin, cout, RoomType, Bed, NoofRoom FROM roombook WHERE Email = ? AND id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $reservation_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a record was found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['stat'];
        $checkin = $row['cin'];
        $checkout = $row['cout'];
        $roomType = $row['RoomType'];
        $bedType = $row['Bed'];
        $noOfRoom = $row['NoofRoom'];

        echo "<div class='notification success'>
                <p>Reservation Status: $status</p>
                <p>Check-In: $checkin</p>
                <p>Check-Out: $checkout</p>
                <p>Room Type: $roomType</p>
                <p>Bedding Type: $bedType</p>
                <p>Number of Rooms: $noOfRoom</p>
              </div>";
    } else {
        echo "<div class='notification error'>
                <p>No reservation found with the provided details.</p>
              </div>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Reservation Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .status-form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .status-form h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .status-form input[type="email"],
        .status-form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .status-form button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .status-form button:hover {
            background-color: #45a049;
        }

        .notification {
            max-width: 400px;
            margin: 20px auto;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
        }

        .notification.success {
            background-color: #4CAF50;
            color: white;
        }

        .notification.error {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>

    <div class="status-form">
        <h2>Check Reservation Status</h2>
        <form action="reservation-status.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="text" name="reservation_id" placeholder="Enter your reservation ID" required>
            <button type="submit" name="check_status">Check Status</button>
        </form>
    </div>

</body>
</html>
