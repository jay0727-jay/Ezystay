<?php   
    include('../config.php');  

    if (isset($_POST['add_admin_submit'])) {  
        $email = $_POST['admin_email'];  
        $password = $_POST['admin_password'];  
        $name = $_POST['admin_name'];  

        // Validate and sanitize inputs  
        $email = mysqli_real_escape_string($conn, $email);  
        $password = mysqli_real_escape_string($conn, $password);  
        $name = mysqli_real_escape_string($conn, $name);  

        // Hash the password  
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);  

        // Prepare SQL query to insert new admin  
        $query = "INSERT INTO admin (email, password, name) VALUES ('$email', '$hashed_password', '$name')";  
    }
        // Execute the query  
        /*if (mysqli_query($conn, $query)) {  
            // Admin added successfully  
            // Redirect to the same page with success parameter  
            header("Location: dashboard.php" . $_SERVER['PHP_SELF'] . "?success=true");  
            exit;  
        } else {  
            // Error adding admin  
            // Redirect to the same page with error parameter  
            header("Location: " . $_SERVER['PHP_SELF'] . "?error=true");  
            exit;  
        }  
    }  */
    ?>   
<!DOCTYPE html>  
<html lang="en">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Add Admin</title>  
    <style>  
        body {  
            font-family: sans-serif;  
            display: flex;  
            justify-content: center;  
            align-items: center;  
            min-height: 100vh;  
            background-color: #f4f4f4;  
        }  

        .container {  
            background-color: #fff;  
            padding: 30px;  
            border-radius: 5px;  
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);  
            width: 400px;  
        }  

        h2 {  
            text-align: center;  
            margin-bottom: 20px;  
        }  

        .form-group {  
            margin-bottom: 15px;  
        }  

        label {  
            display: block;  
            margin-bottom: 5px;  
        }  

        input[type="email"],  
        input[type="password"],  
        input[type="text"] {  
            width: 100%;  
            padding: 10px;  
            border: 1px solid #ccc;  
            border-radius: 3px;  
            box-sizing: border-box;  
        }  

        button[type="submit"] {  
            background-color: #4CAF50;  
            color: white;  
            padding: 10px 20px;  
            border: none;  
            border-radius: 3px;  
            cursor: pointer;  
            width: 100%;  
        }  

        button[type="submit"]:hover {  
            background-color: #45a049;  
        }  

        .popup {  
            display: none;  
            position: fixed;  
            left: 50%;  
            top: 50%;  
            transform: translate(-50%, -50%);  
            background-color: rgba(0, 0, 0, 0.5);  
            width: 100%;  
            height: 100%;  
             
            justify-content: center;  
            align-items: center;  
            z-index: 100;  
        }  

        .popup-content {  
            background-color: white;  
            padding: 20px;  
            border-radius: 5px;  
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);  
            text-align: center;  
        }  

        .popup-close {  
            position: absolute;  
            top: 10px;  
            right: 10px;  
            cursor: pointer;  
        }  

        .popup-message {  
            margin-top: 15px;  
        }  

        .popup-success {  
            color: #4CAF50;  
        }  

        .popup-error {  
            color: #f44336;  
        }  
        .btn-success {
            background-color: white;
            color: green;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            align-items:left;
        }

        .btn-success:hover {
            background-color: blue;
        }
    </style>  
</head>  
<body>  
    <div class="container">  
    <a href="admin.php"><button class="btn btn-success">X</button></a>
        <h2>Add New Admin</h2>  
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">  
            <div class="form-group">  
                <label for="admin_email">Email:</label>  
                <input type="email" id="admin_email" name="admin_email" required>  
            </div>  
            <div class="form-group">  
                <label for="admin_password">Password:</label>  
                <input type="password" id="admin_password" name="admin_password" required>  
            </div>  
            <div class="form-group">  
                <label for="admin_name">Name:</label>  
                <input type="text" id="admin_name" name="admin_name" required>  
            </div>  
            <a href=" admin.php">
            <button type="submit" name="add_admin_submit">Add Admin</button>  </a>
        </form>  

        <!-- Success Popup 
        <div id="successPopup" class="popup">  
            <div class="popup-content">  
                <span class="popup-close" onclick="closePopup('successPopup')">&times;</span>  
                <p class="popup-message popup-success">Admin added successfully!</p>  
            </div>  
        </div>  
-->  
        <!-- Error Popup
        <div id="errorPopup" class="popup">  
            <div class="popup-content">  
                <span class="popup-close" onclick="closePopup('errorPopup')">&times;</span>  
                <p class="popup-message popup-error"></p>  
            </div>  
        </div>  
    </div>  
     
    <script>  
        function closePopup(popupId) {  
            document.getElementById(popupId).style.display = 'flex';  
        }  

        // Show the success popup if it's set in the URL  
        if (window.location.href.indexOf("success=true") !== -1) {  
            document.getElementById('successPopup').style.display = 'flex';  
        }  

        // Show the error popup if it's set in the URL  
        if (window.location.href.indexOf("error=true") !== -1) {  
            document.getElementById('errorPopup').style.display = 'flex';  
        }  
    </script>  
 --> 
    
</body>  
</html>