<?php
include 'config.php';
session_start();

// Fetch reservations, now including Name and stat fields
$sql = "SELECT id, RoomType, Bed, NoofRoom, Meal, cin, Name, stat FROM roombook";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reservations</title>
    <style>
        .logoutbtn {
            height: 20px;
            width: 200px;
            background-color: rgba(116, 182, 124, 0.7);
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .reservation-container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            font-size: 18px;
            color: #555;
        }

        .cancel-button {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-success {
            background-color: green;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-family: Arial, sans-serif;
            font-size: 16px;
            cursor: pointer;
        }

        .btn-success:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>
    <a href="./home.php"><button class="btn btn-success">Back</button></a>
    <h2>All Reservations</h2>
    <div class="reservation-container">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Room Type</th>
                <th>Bed Type</th>
                <th>No of Rooms</th>
                <th>Meal</th>
                <th>Check-In</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            // Check if there are any reservations
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . $row["Name"] . "</td>
                            <td>" . $row["RoomType"] . "</td>
                            <td>" . $row["Bed"] . "</td>
                            <td>" . $row["NoofRoom"] . "</td>
                            <td>" . $row["Meal"] . "</td>
                            <td>" . $row["cin"] . "</td>
                            <td>" . $row["stat"] . "</td> <!-- Display Status -->
                            <td>
                                <a href='cancel_reservation.php?id=" . $row["id"] . "' class='cancel-button'>Cancel</a>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='no-data'>No reservations found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
