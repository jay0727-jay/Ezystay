<?php

include 'config.php';
session_start();

      


// page redirect
$usermail="";
$usermail=$_SESSION['usermail'];
if($usermail == true){

}else{
  header("location: index.php");
}
// Initialize variables to store form data and errors
$Name = $Email = $Country = $Phone = $RoomType = $Bed = $NoofRoom = $Noofpeople = $Meal = $cin = $cout = "";
$error = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $Name = $_POST['Name'];
    $Email = $_POST['Email'];
    $Country = $_POST['Country'];
    $Phone = $_POST['Phone'];
    $RoomType = $_POST['RoomType'];
    $Bed = $_POST['Bed'];
    $NoofRoom = $_POST['NoofRoom'];
    $Noofpeople = $_POST['Noofpeople'];
    $Meal = $_POST['Meal'];
    $cin = $_POST['cin'];
    $cout = $_POST['cout'];
}
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/home.css">
    <title>Ezystay international hotel</title>
    <!-- boot -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- fontowesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <!-- sweet alert -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="./admin/css/roombook.css">
    <style>
  /* roombookcss */



.logoutbtn{
    height: 20px;
    width: 200px;
    background-color:rgba (116, 182, 124, 0.7);
}

#firstsection .welcometag {  
    font-size: 110px;  
    font-weight: bold;  
    font-family: 'Cookie', cursive;  
    letter-spacing: 2px;  
    line-height: 100px;  
    padding: 5px;  
    /* text gradient */  
    background: -webkit-linear-gradient(317deg, rgba(0, 255, 0, 1.5) 0%, rgba(0, 191, 255, 1.5) 100%);  
    background-clip: text; /* Ensures the gradient is applied to the text */  
    -webkit-background-clip: text; /* For Safari */  
    color: transparent; /* Make the text color transparent */  
}
   
      nav{
        position: fixed;
    height: 60px;
    width: 100%;
    background-color: rgba(116, 182, 124, 0.7);
    color: #fff;
    z-index: 200;
    display: flex;
    justify-content: space-between 10px;
    align-items: center;
    padding: 10px 150px;
    box-shadow: 0px 0px 6px 2px rgba(0, 0, 0, 0.386);
    text-align: center;

      }
      nav .logo p {
    font-size: 24px;
    color: rgb(246, 246, 246);
    text-shadow: var(--bg-text-shadow);
}
      nav ul li a {
    text-decoration: none;
    color: rgb(246, 246, 246);
    font-size: 18px;
    position: relative;
}
      #firstsection .carousel-inner::after{
    content: "";
    position: absolute;
    height: 100vh;
    width: 100%;
    background-color: rgba(116, 182, 124, 0.4);
}
.roomselect .roombox{
    height: 100%;
    width: 300px;
    background-color: rgba(116, 182, 124, 2);
    border-radius: 10px;
    overflow: hidden;
    /* margin: 0 20px; */
}
.roomdata h2 {  
  color: white;  
  font-size: 20px; /* Initial size */  
  font-size: calc(1.5em + 2vw); /* Responsive font size */   
}

.roomselect {  
  display: flex; /* Enable Flexbox for the container */  
  flex-wrap: wrap; /* Allow items to wrap onto new lines */  
  justify-content: center; /* Center items horizontally */  
  gap: 20px; /* Add space between the cards */
}  

.roombox {  
  background-color: #4CAF50; /* Example background color */
  flex: 1 1 300px; /* Ensure minimum width of 300px, but allows flexbox to adjust */  
  margin: 10px; /* Add margin for spacing */
  padding: 20px; /* Add padding for inner spacing */
  box-sizing: border-box; /* Ensure padding is included in width/height */
  border-radius: 10px; /* Add rounded corners */
  display: flex; /* Enable Flexbox within each card */
  flex-direction: column; /* Stack child elements vertically */
  justify-content: space-between; /* Distribute space between elements */
  max-width: 400px; /* Ensure a maximum width */
  margin-bottom:100px;
  max-height: 450px;
}

.roombox img {
  width: 100%; /* Make images responsive */
  border-radius: 10px; /* Match the border radius of the container */
}

.roombox h2 {
  color: white;
  font-size: calc(0.7em + 1vw); /* Responsive font size */
  margin: 10px 0; /* Margin for spacing */
}

.roombox .facilities {
  display: flex;
  justify-content: space-between; /* Evenly space out the icons */
  margin: 7px 0;
}

.roombox .book-btn {
  background-color: #007BFF; /* Button color */
  color: white;
  border: none;
  padding: 10px 10px;
  text-align: center;
  border-radius: 5px;
  cursor: pointer;
  align-self: center; /* Center the button horizontally */
  margin-top: 10px; /* Add spacing at the top */
}

.roombox .book-btn:hover {
  background-color: #0056b3; /* Darker blue on hover */
}

.facility .box h2{
  padding-top:10px;
    text-align: center;
    position: relative;
    top: 80%;
    color: white;
    background-color: rgba(116, 182, 124, 0.4);
}
@media (max-width: 768px) { /* Styles for screens smaller than 768px */  
  .roombox {  
    width: 90%; /* Make roomboxes occupy full width on smaller screens */  
    height:80%;
  }  
}
      .footer {
            background-color: #333;
            color: #fff;
            padding: 40px 0;
            position: relative;
        }

        .footer-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-column {
            flex: 1;
            min-width: 200px;
            margin: 10px 20px;
        }

        .footer-column h3 {
            margin-bottom: 20px;
            font-size: 18px;
            border-bottom: 2px solid #007bff;
            display: inline-block;
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
        }

        .footer-column ul li {
            margin-bottom: 10px;
        }

        .footer-column ul li a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: #007bff;
        }

        .footer-icons a {
            margin: 0 10px;
            text-decoration: none;
            color: #fff;
            transition: color 0.3s;
        }

        .footer-icons a:hover {
            color: #007bff;
        }

        .footer-icons a img {
            width: 30px;
            height: 30px;
            transition: transform 0.3s;
        }

        .footer-icons a img:hover {
            transform: scale(1.2);
        }

        .footer-bottom {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
        }
        .book_footer {
    text-align: center; /* Center the content inside the footer */
}

.book_footer .btn-success {
    height: 30px;
    background-color: rgba(116, 182, 124, 0.7);
    padding: 5px 15px;
}


.available-date {
    background-color: rgba(116, 182, 124, 0.7); /* Highlight with your chosen color */
    color: white; /* Change text color for contrast */
}

.unavailable-date {
    background-color: rgba(200, 0, 0, 0.5); /* For non-available dates */
    color: grey; /* Dimmed text color */
}


.modal {  
        display: none;   
        position: fixed;   
        z-index: 1000;   
        left: 0;  
        top: 0;  
        width: 100%;   
        height: 100%;   
        overflow: auto;   
        background-color: rgba(0,0,0,0.7);   
    }  
    
    .modal-content {  
        background-color: #fefefe;  
        margin: 15% auto;   
        padding: 20px;  
        border: 1px solid #888;  
        width: 80%;   
    }  

    .close {  
        color: #aaa;  
        float: right;  
        font-size: 28px;  
        font-weight: bold;  
    }  

    .close:hover,  
    .close:focus {  
        color: black;  
        text-decoration: none;  
        cursor: pointer;  
    }  
    .chat-button {  
        position: fixed;  
        bottom: 20px;  
        right: 20px;  
        background-color: rgba(116, 182, 124, 1.5); /* Color of the chat button */  
        color: white; /* Color of the icon */  
        border-radius: 50%;  
        width: 60px; /* Adjust button size */  
        height: 60px; /* Adjust button size */  
        display: flex;  
        justify-content: center;  
        align-items: center;  
        cursor: pointer;  
        box-shadow: 0 2px 5px rgba(0,0,0,0.3);  
        z-index: 1000; /* Ensure it sits above other content */  
    }  
    
    .chat-button i {  
        font-size: 24px; /* Adjust the icon size */  
    }   
   
//* Modal Background */
.modal {
  display: none; 
  position: fixed; 
  z-index: 1; 
  left: 0;
  top: 0;
  width: 100%; 
  height: 100%; 
  overflow: auto; 
  background-color: rgba(0, 0, 0, 0.4); /* Semi-transparent black background */
}

/* Modal Content */
#bookModal {
  display: none;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: #fff;
  padding: 20px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
  z-index: 1000;
  width: 80%;
  max-width: 600px;
  border-radius: 8px; /* Rounded corners for modal */
}

/* Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}

/* Button Success */
.btn-success {
  background-color: #28a745;
  color: white;
  border: none;
  padding: 10px 20px;
  cursor: pointer;
  border-radius: 4px;
  transition: background-color 0.3s ease;
}

.btn-success:hover {
  background-color: #218838;
}

/* Guest Detail Panel */
#guestdetailpanel {
  height: 105vh;
  width: 100%;
  background-color: rgba(0, 0, 0, 0.558); /* Semi-transparent black background */
  position: fixed;
  z-index: 10000;
  display: none; /* Hidden by default */
  flex-direction: column;
  justify-content: center; /* Center content vertically */
  align-items: center; /* Center content horizontally */
}

/* Section Styles (Guest Info, Reservation Info, Payment Info) */
.guestinfo,  
.reservationinfo, 
.paymentinfo {  
  padding: 20px;  
  background-color: #00B5E2;  /* Light blue background */
  border-radius: 8px;  
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);  
  margin: 10px 0;  
  flex: 1;  
  color: #fff;  /* White text for better contrast */
  box-sizing: border-box;  
  height: 100%;  /* Ensure sections take up full height */
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}  

.paymentinfo {  
  flex: 1.2;  /* Slightly larger width for payment info */
}

/* Footer Button */
.book_footer {  
  display: flex;  
  justify-content: center;  /* Center the submit button */
  padding-top: 20px;  
}  

.book_footer button {  
  height: 40px;  
  background-color: rgba(116, 182, 124, 1);  
  color: white;  
  border: none;  
  border-radius: 8px;  
  padding: 0 20px;  
  cursor: pointer;  
  box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.1);  
  transition: background-color 0.3s ease;  
}  

.book_footer button:hover {  
  background-color: rgba(116, 182, 124, 0.8);  
}

/* Middle Section Layout */
.middle {  
  display: flex;  
  justify-content: space-between;  /* Distribute space evenly between sections */
  gap: 20px;  /* Add space between sections */
  width: 100%;  /* Full width */
  box-sizing: border-box;  /* Include padding and border in element's width/height */
}  

.middle .guestinfo,  
.middle .reservationinfo,  
.middle .paymentinfo {  
  flex: 1;  /* Equal space for each section */
  padding: 20px;  
  border-radius: 8px;  
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);  
  color: #fff;  /* White text color */
  word-wrap: break-word;  /* Ensure text wraps within the box */
  overflow: hidden;  
  box-sizing: border-box;  
}

.middle .paymentinfo {
  flex: 1.2;  /* Slightly larger width for payment info */
}

/* Header and Labels */
.paymentinfo h4,
.paymentinfo label {
  color: white;
}

/* Adjustments for better layout and readability */
.guestinfo input, 
.reservationinfo input, 
.paymentinfo input, 
.guestinfo select, 
.reservationinfo select, 
.paymentinfo select {
  width: 100%;
  padding: 8px;
  margin-top: 8px;
  border-radius: 4px;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

.head h1{
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.head h3 {
  color: #fff;
}

.fa-circle-xmark {
  cursor: pointer;
  color: #fff;
  font-size: 24px;
}

.datesection span {
  display: flex;
  flex-direction: column;
  margin-bottom: 10px;
}

.datesection label {
  color: #fff;
}
 p{
  color:white;
  font-size:13px;
}

</style>

    </style>
</head>

<body>
  <nav>
    <div class="logo">
      <img class="ezystaylogo" src="./image/ezystaylogo.png" alt="logo">
      <p>Ezystay</p>
    </div>
    <ul>
      <li><a href="#firstsection">Home</a></li>
      <li><a href="#secondsection">Rooms</a></li>
      <li><a href="#thirdsection">Facilites</a></li>
      <li><a href="#contactus">contact us</a></li>
      <a href="./feedback_form.php"><button class="btn btn-success">Feedback</button></a>
      <a href="./reservation-view.php"><button class="btn btn-success">Reservation status</button></a>
      <a href="./logout.php"><button class="btn btn-danger">Logout</button></a>
      
    </ul>
  </nav>

  <section id="firstsection" class="carousel slide carousel_section" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="carousel-image" src="image/h1.jpg">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="../ezystay/image/h2.jpg">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="../ezystay/image/h3.jpg">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="../ezystay/image/h4.jpg">
        </div>

        <div class="welcomeline">
          <h1 class="welcometag">Welcome to heaven on earth</h1>
        </div>

      <!-- bookbox -->
      <!-- bookbox -->
<div id="guestdetailpanel" style="">
    <form action="" method="POST" class="guestdetailpanelform" style="flex: 2;">
        <div class="head">
            <h3>RESERVATION</h3>
            <i class="fa-solid fa-circle-xmark" onclick="closebox()"></i>
        </div>
        <div class="middle" style="display: flex;">
            <!-- Guest and Reservation Info -->
            <div class="guestinfo" style="flex: 1;">
                <h4>Guest Information</h4>
                <input type="text" name="Name" placeholder="Enter Full name">
                <input type="email" name="Email" placeholder="Enter Email">
                <?php
                    $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
                    ?>
                <select name="Country" class="selectinput">
                    <option value selected>Select your country</option>
                    <?php
                        foreach($countries as $key => $value):
                        echo '<option value="'.$value.'">'.$value.'</option>';
                        endforeach;
                    ?>
                </select>
                <input type="text" name="Phone" placeholder="Enter Phoneno">
            </div>
           
            <!-- reservation-->
            <div class="reservationinfo" style="flex: 1;">
                <h4>Reservation Information</h4>
                <select name="RoomType" class="selectinput">
                    <option value selected>Type Of Room</option>
                    <option value="Superior Room">SUPERIOR ROOM</option>
                    <option value="Deluxe Room">DELUXE ROOM</option>
                    <option value="Guest House">GUEST HOUSE</option>
                    <option value="Single Room">Normal ROOM</option>
                </select>
                <select name="Bed" class="selectinput">
                    <option value selected>Bedding Type</option>
                    <option value="Single">Single</option>
                    <option value="Double">Double</option>
                    <option value="Triple">Triple</option>
                    <option value="Quad">Quad</option>
                    <option value="None">None</option>
                </select>
                <select name="NoofRoom" class="selectinput">
                    <option value selected>No of Room</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <select name="Noofpeople" class="selectinput">
                    <option value selected>No of People</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
                <select name="Meal" class="selectinput">
                    <option value selected>Meal</option>
                    <option value="Room only">Room only</option>
                    <option value="Breakfast">Breakfast</option>
                    <option value="Half Board">Half Board</option>
                    <option value="Full Board">Full Board</option>
                </select>
                <div class="datesection">
                    <span>
                        <label for="cin"> Check-In</label>
                        <input name="cin" type="date">
                    </span>
                    <span>
                        <label for="cout"> Check-Out</label>
                        <input name="cout" type="date">
                    </span>
                </div>
            </div>
             <!-- Payment Info Section -->
    <div class="paymentinfo" style="flex: 1; margin-left: 20px; padding: 20px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); border-radius: 8px;">
        <h4>Payment Information</h4>
        <label for="cardName">Name on Card</label>
        <input type="text" id="cardName" name="cardName" placeholder="Enter Name on Card">

        <label for="cardNumber">Card Number</label>
        <input type="text" id="cardNumber" name="cardNumber" placeholder="Enter Card Number">

        <label for="expDate">Expiration Date</label>
        <input type="text" id="expDate" name="expDate" placeholder="MM/YY">

        <label for="cvv">CVV</label>
        <input type="text" id="cvv" name="cvv" placeholder="Enter CVV">

        <label for="billingAddress">Billing Address</label>
        <input type="text" id="billingAddress" name="billingAddress" placeholder="Enter Billing Address">

    </div>

        </div>
                   
        <div class="book_footer">
            <button class="btn btn-success" name="guestdetailsubmit" style="height:30px; background-color:rgba(116, 182, 124, 0.7);">Submit</button>
        </div>

    </form>




        <!-- ==== room book php ====-->
        <?php       
            if (isset($_POST['guestdetailsubmit'])) {
                $Name = $_POST['Name'];
                $Email = $_POST['Email'];
                $Country = $_POST['Country'];
                $Phone = $_POST['Phone'];
                $RoomType = $_POST['RoomType'];
                $Bed = $_POST['Bed'];
                $NoofRoom = $_POST['NoofRoom'];
                $Meal = $_POST['Meal'];
                $cin = $_POST['cin'];
                $cout = $_POST['cout'];

                if($Name == "" || $Email == "" || $Country == ""){
                    echo "<script>swal({
                        title: 'Fill the proper details',
                        icon: 'error',
                    });
                    </script>";
                }
                else{
                    $sta = "NotConfirm";
                    $sql = "INSERT INTO roombook(Name,Email,Country,Phone,RoomType,Bed,NoofRoom,Meal,cin,cout,stat,nodays) VALUES ('$Name','$Email','$Country','$Phone','$RoomType','$Bed','$NoofRoom','$Meal','$cin','$cout','$sta',datediff('$cout','$cin'))";
                    $result = mysqli_query($conn, $sql);

                    
                        if ($result) {
                            echo "<script>swal({
                                title: 'Reservation successful',
                                icon: 'success',
                            });
                        </script>";
                        } else {
                            echo "<script>swal({
                                    title: 'Something went wrong',
                                    icon: 'error',
                                });
                        </script>";
                        }
                }
            }
            ?>
          </div>

    </div>
    
  </section>
  
  <section id="secondsection"> 
    <img src="./image/homeanimatebg.svg">
    <div class="ourroom">
      <h1 class="head">≼ Our room ≽</h1>
      <div class="roomselect">
        <div class="roombox">
          <div class="hotelphoto h1"></div>
          <div class="roomdata">
            <h2>Superior Room</h2>
            <p>A spacious room with a king-size bed, a stunning view, and luxury amenities. Perfect for a relaxing stay. Charges: $250/night.</p>
            <div class="services">
              <i class="fa-solid fa-wifi"></i>
              <i class="fa-solid fa-burger"></i>
              <i class="fa-solid fa-spa"></i>
              <i class="fa-solid fa-dumbbell"></i>
              <i class="fa-solid fa-person-swimming"></i>
            </div>
            <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button>
          </div>
        </div>
        <div class="roombox">
          <div class="hotelphoto h2"></div>
          <div class="roomdata">
            <h2>Delux Room</h2>
            <p>An elegant room with a queen-size bed, offering comfort and modern amenities. Ideal for business or leisure. Charges: $200/night.</p>
            <div class="services">
              <i class="fa-solid fa-wifi"></i>
              <i class="fa-solid fa-burger"></i>
              <i class="fa-solid fa-spa"></i>
              <i class="fa-solid fa-dumbbell"></i>
            </div>
            <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button>
          </div>
        </div>
        <div class="roombox">
          <div class="hotelphoto h3"></div>
          <div class="roomdata">
            <h2>Guest Room</h2>
            <p>A cozy room with a double bed, suitable for short stays with essential facilities. Charges: $150/night.</p>
            <div class="services">
              <i class="fa-solid fa-wifi"></i>
              <i class="fa-solid fa-burger"></i>
              <i class="fa-solid fa-spa"></i>
            </div>
            <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button>
          </div>
        </div>
        <div class="roombox">
          <div class="hotelphoto h4"></div>
          <div class="roomdata">
            <h2>Single Room</h2>
            <p>A compact room with a single bed, perfect for solo travelers seeking comfort at an affordable price. Charges: $100/night.</p>
            <div class="services">
              <i class="fa-solid fa-wifi"></i>
              <i class="fa-solid fa-burger"></i>
            </div>
            <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button>
          </div>
        </div>
      </div>
    </div>
</section>


 

<section>
<div id="notification-section" class="notification-section">
    <div id="notification-message" class="notification-message"></div>
</div>

        </section>
  

<section id="thirdsection">  
    <h1 class="head">≼ Facilities ≽</h1>  
    <div class="facility">  
        <div class="box" onclick="showFacilityDetails('Swimming Pool', 'Enjoy our luxurious swimming pool.', 'pool.jpg')">  
            <h2>Swimming Pool</h2>  
        </div>  
        <div class="box" onclick="showFacilityDetails('Spa', 'Relax and rejuvenate at our spa.', 'spa.jpg')">  
            <h2>Spa</h2>  
        </div>  
        <div class="box" onclick="showFacilityDetails('24/7 Restaurants', 'Enjoy meals at any hour at our restaurants.', 'restaurant.jpg')">  
            <h2>24/7 Restaurants</h2>  
        </div>  
        <div class="box" onclick="showFacilityDetails('24/7 Gym', 'Stay fit with our 24/7 gym facilities.', 'gym.jpg')">  
            <h2>24/7 Gym</h2>  
        </div>  
        <div class="box" onclick="showFacilityDetails('Heli Service', 'Experience luxury travel with our heli service.', 'heli_service.jpg')">  
            <h2>Heli Service</h2>  
        </div>  
    </div>  
</section>  

<!-- Modal Structure for Facilities -->  
<div id="facilityModal" class="modal" style="display:none;">  
    <div class="modal-content">  
        <span class="close" onclick="closeFacilityModal()">&times;</span>  
        <h2 id="modalFacilityTitle"></h2>  
        <p id="modalFacilityDescription"></p>  
        <img id="modalFacilityImage" src="" alt="Facility Image" />  
    </div>  
</div>  


  <div class="footer" id="contactus">
        <div class="footer-container">
            <div class="footer-column">
                <h3>Contact Us</h3>
                <ul>
                    <li>123 Main Street</li>
                    <li>City, State, 12345</li>
                    <li>Email: info@example.com</li>
                    <li>Phone: (123) 456-7890</li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="#contactus">About Us</a></li>
                    <li><a href="#thirdsection">Services</a></li>
                    <li><a href="#contactus">Contact</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Follow Us</h3>
                <div class="footer-icons">
                    <a href="https://www.instagram.com" target="_blank">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" alt="Instagram">
                    </a>
                    <a href="https://www.facebook.com" target="_blank">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/51/Facebook_f_logo_%282019%29.svg" alt="Facebook">
                    </a>
                    <a href="mailto:info@example.com">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/4/4e/Gmail_Icon.png" alt="Email">
                    </a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            Created by EzyStay. All rights reserved.
        </div>
    </div>
    <div id="chat-button" class="chat-button" onclick="window.location.href='comingsoon.html'">  
    <i class="fa-solid fa-comment-dots"></i>  
</div>  
</body>

<script>



// Book detail panel
var bookbox = document.getElementById("guestdetailpanel");

// Function to open guest detail panel
function openGuestDetailPanel() {
    bookbox.style.display = "flex";
}

// Function to close the guest detail panel
function closebox() {
    bookbox.style.display = 'none';
}

// Attach event listeners to all "Book" buttons
document.querySelectorAll('.bookbtn').forEach(button => {
    button.addEventListener('click', openGuestDetailPanel);
});

// Event listener for the close icon
document.querySelector('.fa-circle-xmark').addEventListener('click', closebox);

// Modal for room details
var modal = document.getElementById("bookModal");
var closeBtn = document.getElementsByClassName("close")[0];




    // for date color if available or not

    document.addEventListener('DOMContentLoaded', function() {
    const availableDates = {
        '2024-08-20': true,
        '2024-08-21': true,
        '2024-08-22': false,
        '2024-08-23': true,
        // Add more dates as needed
    };

    const checkInInput = document.getElementById('checkIn');
    const checkOutInput = document.getElementById('checkOut');

    checkInInput.addEventListener('input', function() {
        updateDateAvailability(checkInInput);
    });

    checkOutInput.addEventListener('input', function() {
        updateDateAvailability(checkOutInput);
    });




    function updateDateAvailability(input) {
        const selectedDate = input.value;
        if (availableDates[selectedDate]) {
            input.classList.add('available-date');
            input.classList.remove('unavailable-date');
        } else {
            input.classList.add('unavailable-date');
            input.classList.remove('available-date');
        }
    }
});

// for our room on click
/*function showRoomDetails(title, description, image) {  
        document.getElementById("modalRoomTitle").innerText = title;  
        document.getElementById("modalRoomDescription").innerText = description;  
        document.getElementById("modalRoomImage").src = image;  
        document.getElementById("roomModal").style.display = "block";  
    }  

    function closeModal() {  
        document.getElementById("roomModal").style.display = "none";  
    }  

    // To close modal when clicking outside of the modal content  
    window.onclick = function(event) {  
        if (event.target === document.getElementById("roomModal")) {  
            closeModal();  
        }  
    }  */

// for services on click
function showFacilityDetails(title, description, image) {  
        document.getElementById("modalFacilityTitle").innerText = title;  
        document.getElementById("modalFacilityDescription").innerText = description;  
        document.getElementById("modalFacilityImage").src = image;  
        document.getElementById("facilityModal").style.display = "block";  
    }  

    function closeFacilityModal() {  
        document.getElementById("facilityModal").style.display = "none";  
    }  

    // To close modal when clicking outside of the modal content  
    window.onclick = function(event) {  
        if (event.target === document.getElementById("facilityModal")) {  
            closeFacilityModal();  
        }  
    }  

// reservation and booking section


//live chat
function openChat() {  
        // Logic to open your chat service  
        // Example for Tawk.to (replace with your actual script)  
        Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();  
        (function() {  
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];  
            s1.async = true;  
            s1.src = 'https://embed.tawk.to/your_tawk_id_here/default'; // Replace with your Tawk.to code  
            s1.charset = 'UTF-8';  
            s1.setAttribute('crossorigin', '*');  
            s0.parentNode.insertBefore(s1, s0);  
        })();  
    }  

  

</script>
</html>