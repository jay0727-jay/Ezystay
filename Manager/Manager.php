<?php

include '../config.php';
session_start();

// page redirect
$usermail="";
$usermail=$_SESSION['usermail'];
if($usermail == true){

}else{
  header("location: http://localhost/hotelmanage_system/index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/admin.css">
    <style>
        .uppernav{
    height: 50px;
    background-color: rgba(116, 182, 124, 0.7); 
    background-image: linear-gradient(90deg, rgba(116, 182, 124, 0.9), rgba(34, 193, 195, 0.5));

    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 5px 40px;
}
.sidenav {
    position: absolute;
    background-color: #2c6b4f; /* Greenish background color */
    width: 18%;
    height: 100%;
    color: #ffffff; /* Keep the text color white for contrast */
}
ul li{
    display: flex;
    /* justify-content: center; */
    align-items: center;
    padding: 0px 10px;
    height: 50px;
    cursor: pointer;
    margin-bottom: 5px;
}
ul li:hover{
    background-color: #3a8f5a;
}
ul li.active{
    background-color: #3a8f5a;
}
        </style>
    <!-- loading bar -->
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="../css/flash.css">
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Ezystay- Manager</title>
</head>

<body>
    <!-- mobile view -->
    <div id="mobileview">
        <h5>Admin panel doesn't show in mobile view</h4>
    </div>
  
    <!-- nav bar -->
    <nav class="uppernav">
        <div class="logo">
            <img class="Ezystaylogo" src="../image/Ezystaylogo.png" alt="logo">
            <p>Ezystay</p>
        </div>
        <div class="logout">
        <a href="../logout.php"><button class="btn btn-primary">Logout</button></a>
        </div>
    </nav>
    <nav class="sidenav">
        <ul>
            <li class="pagebtn active"><img src="../image/icon/dashboard.png">&nbsp&nbsp&nbsp Dashboard</li>
            <li class="pagebtn"><img src="../image/icon/bed.png">&nbsp&nbsp&nbsp Room Booking</li>
            <li class="pagebtn"><img src="../image/icon/wallet.png">&nbsp&nbsp&nbsp Payment</li>            
            <li class="pagebtn"><img src="../image/icon/bedroom.png">&nbsp&nbsp&nbsp Rooms</li>
            <li class="pagebtn"><img src="../image/icon/feedback.png">&nbsp&nbsp&nbsp Task visualization</li>
            <li class="pagebtn"><img src="../image/icon/staffscedule.png">&nbsp&nbsp&nbsp Staff</li>
            <li class="pagebtn"><img src="../image/icon/household.png">&nbsp&nbsp&nbsp House keeping management</li>
            <li class="pagebtn"><img src="../image/icon/work.png">&nbsp&nbsp&nbsp Staff scheduling</li>
            <li class="pagebtn"><img src="../image/icon/feedback.png">&nbsp&nbsp&nbsp Feeback</li>
        </ul>
    </nav>

    <!-- main section -->
    <div class="mainscreen">
        <iframe class="frames frame1 active" src="./dashboard.php" frameborder="0"></iframe>
        <iframe class="frames frame2" src="./roombook.php" frameborder="0"></iframe>
        <iframe class="frames frame3" src="./payment.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./room.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./staff.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./task.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./housekeeping_with_knn_and_html.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./staff_schedule.php" frameborder="0"></iframe>
        <iframe class="frames frame4" src="./view_feedback.php" frameborder="0"></iframe>
    </div>

    
</body>

<script src="./javascript/script.js"></script>

</html>
