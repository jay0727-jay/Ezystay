
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #e0e0e0;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }

        .feedback-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .feedback-form label {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .feedback-form select, .feedback-form textarea, .feedback-form button {
            padding: 12px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            width: 100%;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .feedback-form select:focus, .feedback-form textarea:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .feedback-form textarea {
            resize: vertical;
            min-height: 100px;
        }

        .feedback-form button {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .feedback-form button:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .feedback-form button:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }
        .go-back {  
            font-size: 24px;  
            text-decoration: none;  
            color: #000; /* Changed color to black */  
            position: absolute;  
            top: 10px;  
            left: 10px;  
            cursor: pointer;  
        }  
        .popup {
            display: none; /* Hidden by default */
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 1px solid black;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.5);
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
        .head{
    text-align: center;
    margin-bottom: 40px;
}

    </style>
</head>
<body>

    <div class="container">
        
      
      <a href="./home.php"><button class="btn btn-success">X</button></a>
        <h1>Submit Your Feedback</h1>
        
        <form id="feedbackForm" class="feedback-form">
            <label for="rating">Rating:</label>
            <select id="rating" name="rating" required>
                <option value="5">5 Stars</option>
                <option value="4">4 Stars</option>
                <option value="3">3 Stars</option>
                <option value="2">2 Stars</option>
                <option value="1">1 Star</option>
            </select>

            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments" required></textarea>

            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="Cleanliness">Cleanliness</option>
                <option value="Service">Service</option>
                <option value="Food Quality">Food Quality</option>
                <option value="Value">Value</option>
            </select>

            <input type="hidden" id="guest_id" name="guest_id" value="123"> <!-- Example guest_id -->

            <button type="submit" class="btn btn-success">Submit Feedback</button>
        </form>
    </div>

    <div class="popup" id="popup">
        <p id="popupMessage"></p>
        <a href="Home.php"><button onclick="closePopup()" class="btn btn-success">Close</button></a>
    </div>

    <script>
        document.getElementById('feedbackForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            var formData = new FormData(this);

            fetch('submit_feedback.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                showPopup(data);
            })
            .catch(error => {
                console.error('Error:', error);
                showPopup('An error occurred while submitting your feedback.');
            });
        });

        function showPopup(message) {
            var popup = document.getElementById('popup');
            document.getElementById('popupMessage').textContent = message;
            popup.style.display = 'block';
        }
        var bookbox = document.getElementById("guestdetailpanel");

openbookbox = () =>{
  bookbox.style.display = "flex";
}
closebox = () =>{
  bookbox.style.display = "none";
}
     
    </script>
</body>
</html>
