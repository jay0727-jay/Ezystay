<?php

include '../config.php';

// Check if the ID is provided via GET request
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the reservation details using prepared statements
    $sql = "SELECT * FROM roombook WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $Name = $row['Name'];
        $Email = $row['Email'];
        $Country = $row['Country'];
        $Phone = $row['Phone'];
        $RoomType = $row['RoomType'];
        $Bed = $row['Bed'];
        $NoofRoom = $row['NoofRoom'];
        $Meal = $row['Meal'];
        $cin = $row['cin'];
        $cout = $row['cout'];
        $noofday = $row['nodays'];
        $stat = $row['stat'];

        // Debugging: Check the current status
        echo "Current status: " . $stat . "<br>";

        if ($stat == "NotConfirm") {
            $st = "Confirm";

            // Update the reservation status
            $update_sql = "UPDATE roombook SET stat = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param('ss', $st, $id);
            $update_result = $update_stmt->execute();

            if ($update_result) {
                // Debugging: Confirm status update
                echo "Status updated to Confirm.<br>";

                // Proceed with the cost calculations
                $room_prices = [
                    "Superior Room" => 3000,
                    "Deluxe Room" => 2000,
                    "Guest House" => 1500,
                    "Single Room" => 1000
                ];
                $type_of_room = $room_prices[$RoomType] ?? 0;

                // Determine the bed cost
                $bed_multipliers = [
                    "Single" => 1,
                    "Double" => 2,
                    "Triple" => 3,
                    "Quad" => 4,
                    "None" => 0
                ];
                $type_of_bed = $type_of_room * ($bed_multipliers[$Bed] ?? 0) / 100;

                // Determine the meal cost
                $meal_multipliers = [
                    "Room only" => 0,
                    "Breakfast" => 2,
                    "Half Board" => 3,
                    "Full Board" => 4
                ];
                $type_of_meal = $type_of_bed * ($meal_multipliers[$Meal] ?? 0);

                // Calculate totals
                $ttot = $type_of_room * $noofday * $NoofRoom;
                $mepr = $type_of_meal * $noofday;
                $btot = $type_of_bed * $noofday;
                $fintot = $ttot + $mepr + $btot;

                // Insert into the payment table using prepared statements
                $psql = "INSERT INTO payment(id, Name, Email, RoomType, Bed, NoofRoom, cin, cout, noofdays, roomtotal, bedtotal, meal, mealtotal, finaltotal) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $pstmt = $conn->prepare($psql);
                $pstmt->bind_param(
                    'ssssssssddddds',
                    $id, $Name, $Email, $RoomType, $Bed, $NoofRoom, $cin, $cout, $noofday, 
                    $ttot, $btot, $Meal, $mepr, $fintot
                );
                $pstmt->execute();

                // Debugging: Confirm payment insertion
                if ($pstmt->affected_rows > 0) {
                    echo "Payment record inserted.<br>";
                } else {
                    echo "Error: Payment record not inserted.<br>";
                }

                // Redirect to the roombook page
                header("Location: roombook.php");
                exit;
            } else {
                echo "Error: Could not update reservation status.<br>";
            }
        } else {
            echo "<script>alert('Guest Already Confirmed')</script>";
            header("Location: roombook.php");
            exit;
        }
    } else {
        echo "Error: Reservation not found.<br>";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Error: ID not provided.<br>";
}

?>
