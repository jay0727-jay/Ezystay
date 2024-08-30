<?php
    session_start();
    include '../config.php';

    // Fetch recent housekeeping tasks
    $tasksql = "SELECT task, room_number, status FROM housekeeping_tasks ORDER BY id DESC LIMIT 5";
    $taskresult = mysqli_query($conn, $tasksql);

    // Fetch recent staff tasks
    $notification_query = "SELECT st.name, s.date, s.shift FROM schedule s 
                       JOIN staff st ON s.staff_id = st.id 
                       WHERE s.date >= CURDATE()
                       ORDER BY s.date ASC, s.shift ASC 
                       LIMIT 5";
$notification_result = mysqli_query($conn, $notification_query);
    // roombook
    $roombooksql ="SELECT * FROM roombook";
    $roombookre = mysqli_query($conn, $roombooksql);
    $roombookrow = mysqli_num_rows($roombookre);

    // staff
    $staffsql ="SELECT * FROM staff";
    $staffre = mysqli_query($conn, $staffsql);
    $staffrow = mysqli_num_rows($staffre);

    // room
    $roomsql ="SELECT * FROM room";
    $roomre = mysqli_query($conn, $roomsql);
    $roomrow = mysqli_num_rows($roomre);

    // roombook roomtype
    $chartroom1 = "SELECT * FROM roombook WHERE RoomType='Superior Room'";
    $chartroom1re = mysqli_query($conn, $chartroom1);
    $chartroom1row = mysqli_num_rows($chartroom1re);

    $chartroom2 = "SELECT * FROM roombook WHERE RoomType='Deluxe Room'";
    $chartroom2re = mysqli_query($conn, $chartroom2);
    $chartroom2row = mysqli_num_rows($chartroom2re);

    $chartroom3 = "SELECT * FROM roombook WHERE RoomType='Guest House'";
    $chartroom3re = mysqli_query($conn, $chartroom3);
    $chartroom3row = mysqli_num_rows($chartroom3re);

    $chartroom4 = "SELECT * FROM roombook WHERE RoomType='Single Room'";
    $chartroom4re = mysqli_query($conn, $chartroom4);
    $chartroom4row = mysqli_num_rows($chartroom4re);

    // moriss profit
    $query = "SELECT * FROM payment";
    $result = mysqli_query($conn, $query);
    $chart_data = '';
    $tot = 0;
    while($row = mysqli_fetch_array($result)) {
        $chart_data .= "{ date:'".$row["cout"]."', profit:".$row["finaltotal"]*10/100 ."}, ";
        $tot = $tot + $row["finaltotal"]*10/100;
    }

    $chart_data = substr($chart_data, 0, -2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/dashboard.css">
    <style>
      /* General Styles for Dashboard */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}


/* Notifications Bar */
.notifications-bar {
    background-color: #fff;
    color: black;
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    border-bottom: 8px solid brown; 
}

.notifications-bar h2 {
    margin: 0 0 10px 0;
    font-size: 20px;
    font-weight: bold;
    color: #333;
}

.notifications-bar ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}

.notifications-bar ul li {
    margin: 5px 0;
    font-size: 16px;
}

.notifications-bar ul li strong {
    font-weight: bold;
    color: #007bff;
}

/* Databoxes */
.databox {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.databox .box {
    flex: 1;
    padding: 20px;
    margin: 0 10px;
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.databox .box h2 {
    margin-bottom: 10px;
    font-size: 16px;
    color: #333;
}

.databox .box h1 {
    font-size: 50px;
    color: #007bff;
}

.databox .box span {
    font-size: 20px;
    color: #333;
}
.databox .box h1{
    font-size: 80px;
    font-family: 'Hind Siliguri', sans-serif;
    color: black;
}
/* Chartbox */
.chartbox {
    display: flex;
    justify-content: space-between;
}

.chartbox .bookroomchart, .chartbox .profitchart {
    flex: 1; /* Reduced flex to make the boxes smaller */
    padding: 10px; /* Reduced padding */
    margin: 0 10px; /* Reduced margin to decrease spacing between boxes */
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.chartbox .bookroomchart canvas, .chartbox .profitchart #profitchart {
    width: 100%; 
    height: 300px; /* Reduced height to make charts smaller */
}

.chartbox h3 {
    font-size: 24px; /* Reduced font size slightly */
    color: #333;
}

      </style>
    <!-- chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- morish bar -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <title>Ezystay - Admin </title>
</head>
<body>
  
    <div class="notifications-bar">
    <h2>Recent Housekeeping Tasks</h2>
        <ul>
        <?php
            if (mysqli_num_rows($taskresult) > 0) {
                while ($task = mysqli_fetch_assoc($taskresult)) {
                    echo "<li>Task: " . $task['task'] . " in Room " . $task['room_number'] . " - Status: " . ucfirst($task['status']) . "</li>";
                }
            } else {
                echo "<li>No recent tasks.</li>";
            }
                
            ?>
      </ul> 
        <h2>Emergency Duty Schedule</h2>
        <ul>
            <?php
           if (mysqli_num_rows($notification_result) > 0) {
            while ($notification = mysqli_fetch_assoc($notification_result)) {
                $staff_name = htmlspecialchars($notification['name']);
                $shift = ucfirst(htmlspecialchars($notification['shift']));
                $date = htmlspecialchars($notification['date']);
                
                echo "<li>Notification: $staff_name is scheduled for the $shift shift on $date.</li>";
            }
        } else {
            echo "<li>No upcoming schedules found.</li>";
        }
            ?>
        </ul>
    </div>
 
    <div class="databox">
        <div class="box roombookbox">
          <h2>Total Booked Room</h2>  
          <h1><?php echo $roombookrow ?> / <?php echo $roomrow ?></h1>
        </div>
        <div class="box guestbox">
          <h2>Total Staff</h2>  
          <h1><?php echo $staffrow ?></h1>
        </div>
        <div class="box profitbox">
          <h2>Profit</h2>  
          <h1><?php echo $tot?> <span>$</span></h1>
        </div>
    </div>

    <div class="chartbox">
        <div class="bookroomchart">
            <canvas id="bookroomchart"></canvas>
            <h3 style="text-align: center;margin:10px 0;">Booked Room</h3>
        </div>
        <div class="profitchart">
            <div id="profitchart"></div>
            <h3 style="text-align: center;margin:10px 0;">Profit</h3>
        </div>
    </div>

    <script>
        const labels = [
            'Superior Room',
            'Deluxe Room',
            'Guest House',
            'Single Room',
        ];

        const data = {
            labels: labels,
            datasets: [{
                label: 'Booked Rooms',
                backgroundColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(153, 102, 255, 1)',
                ],
                borderColor: 'black',
                data: [<?php echo $chartroom1row ?>,<?php echo $chartroom2row ?>,<?php echo $chartroom3row ?>,<?php echo $chartroom4row ?>],
            }]
        };

        const doughnutchart = {
            type: 'doughnut',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('bookroomchart'),
            doughnutchart
        );
    </script>

    <script>
        Morris.Bar({
            element : 'profitchart',
            data:[<?php echo $chart_data;?>],
            xkey:'date',
            ykeys:['profit'],
            labels:['Profit'],
            hideHover:'auto',
            stacked:true,
            barColors:[
                'rgba(153, 102, 255, 1)',
            ]
        });
    </script>
</body>
</html>
