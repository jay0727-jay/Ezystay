<?php
include '../config.php';
session_start();

// Redirect if not logged in
if (!isset($_SESSION['usermail']) || empty($_SESSION['usermail'])) {
    header("Location: http://localhost/hotelmanage_system/index.php");
    exit();
}

// Handle form submission for adding schedule
if (isset($_POST['submit'])) {
    $staff_id = $_POST['staff_id'];
    $date = $_POST['date'];
    $shift = $_POST['shift'];

    $query = "INSERT INTO schedule (staff_id, date, shift) VALUES ('$staff_id', '$date', '$shift')";
    if (!mysqli_query($conn, $query)) {
        die("Error adding schedule: " . mysqli_error($conn));
    }
    header('Location: staff_schedule.php');
    exit();
}

// Handle schedule deletion
if (isset($_POST['delete'])) {
    $id = $_POST['delete_id'];
    $query = "DELETE FROM schedule WHERE id=$id";
    if (!mysqli_query($conn, $query)) {
        die("Error deleting schedule: " . mysqli_error($conn));
    }
    header('Location: staff_schedule.php');
    exit();
}

// Retrieve staff members
$staff_query = "SELECT * FROM staff";
$staff_result = mysqli_query($conn, $staff_query);

// Retrieve schedules
$schedule_query = "SELECT s.id, st.name, s.date, s.shift FROM schedule s JOIN staff st ON s.staff_id = st.id";
$schedule_result = mysqli_query($conn, $schedule_query);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Scheduling</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* styles.css */
/* styles.css */
body {
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    font-family: Arial, sans-serif;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #333;
}

.schedule-form {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 20px;
    background-color: #f1f1f1;
    padding: 15px;
    border-radius: 8px;
}

.schedule-form select, .schedule-form input, .schedule-form button {
    padding: 12px;
    font-size: 16px;
    border-radius: 4px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

.schedule-form select {
    width: calc(100% - 24px); /* Ensure the select dropdown doesn't overflow */
}

.schedule-form select:focus, .schedule-form input:focus, .schedule-form button:focus {
    outline: none;
    border-color: #007bff;
}

.schedule-form button {
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    border: none;
}

.schedule-form button:hover {
    background-color: #0056b3;
}

.schedule-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.schedule-table th, .schedule-table td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

.schedule-table th {
    background-color: #007bff;
    color: #ffffff;
}

.schedule-table td {
    background-color: #ffffff;
}

.schedule-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.schedule-table tr:hover {
    background-color: #f1f1f1;
}

.schedule-table td button {
    padding: 6px 12px;
    font-size: 14px;
    color: #ffffff;
    background-color: #28a745;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.schedule-table td button:hover {
    background-color: #218838;
}

        </style>
</head>
<body>
    <div class="container">
        <h1>Staff Scheduling</h1>
        <form action="staff_schedule.php" method="post" class="schedule-form">
            <select name="staff_id" required>
                <option value="">Select Staff Member</option>
                <?php while ($staff = mysqli_fetch_assoc($staff_result)) { ?>
                    <option value="<?php echo $staff['id']; ?>"><?php echo $staff['name'];  ?></option>
                <?php } ?>
            </select>
            <input type="date" name="date" required>
            <select name="shift" required>
                <option value="">Select Shift</option>
                <option value="morning">Morning</option>
                <option value="afternoon">Afternoon</option>
                <option value="evening">Evening</option>
                <option value="night">Night</option>
            </select>
            <button type="submit" name="submit" class="btn">Add Schedule</button>
        </form>
        <table class="schedule-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Staff Member</th>
                    <th>Date</th>
                    <th>Shift</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($schedule = mysqli_fetch_assoc($schedule_result)) { ?>
                    <tr>
                        <td><?php echo $schedule['id']; ?></td>
                        <td><?php echo $schedule['name']; ?></td>
                        <td><?php echo $schedule['date']; ?></td>
                        <td><?php echo ucfirst($schedule['shift']); ?></td>
                        <td>
                            <form action="staff_schedule.php" method="post" style="display:inline;">
                                <input type="hidden" name="delete_id" value="<?php echo $schedule['id']; ?>">
                                <button type="submit" name="delete" class="btn delete-btn">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
