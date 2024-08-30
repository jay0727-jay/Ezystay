
       



<?php
include '../config.php'; // Include your database connection

// Fetch tasks from the database
$sql = "SELECT * FROM tasks ORDER BY id ASC";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching tasks: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management</title>
    <style>
  /* Universal Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Arial', sans-serif;
}

body {
    background-color: #f0f2f5;
    color: #333;
    line-height: 1.6;
}

/* Container for the Task Management App */
.task-management {
    max-width: 1200px;
    margin: 40px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

/* Header */
h2 {
    margin-bottom: 20px;
    text-align: center;
    color: #333;
    font-size: 2em;
}

/* Task Form Styles */
#task-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    margin-bottom: 30px;
    padding: 20px;
    border-radius: 8px;
    background-color: #f7f7f7;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
}

#task-form input, 
#task-form textarea, 
#task-form select {
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1em;
}

#task-form input:focus, 
#task-form textarea:focus, 
#task-form select:focus {
    outline: none;
    border-color: #007BFF;
}

#task-form button {
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
    transition: background-color 0.3s;
}

#task-form button:hover {
    background-color: #0056b3;
}

/* Task Lists Container */
.task-lists {
    display: flex;
    gap: 20px;
    justify-content: space-between;
    flex-wrap: wrap;
}

.task-list-container {
    flex: 1;
    min-width: 300px;
    margin-bottom: 20px;
}

/* Task List Header */
.task-list-container h3 {
    margin-bottom: 10px;
    padding: 10px;
    background-color: #007BFF;
    color: white;
    text-align: center;
    border-radius: 5px;
    font-size: 1.2em;
}

/* Task List Styles */
.task-list {
    list-style-type: none;
    padding: 10px;
    background-color: #f9f9f9;
    border-radius: 5px;
    min-height: 200px;
    border: 1px solid #ddd;
    transition: background-color 0.3s ease;
}

.task-list:hover {
    background-color: #f1f1f1;
}

/* Task Card Styles */
.task-card {
    padding: 15px;
    margin-bottom: 10px;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    cursor: grab;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
}

.task-card:active {
    cursor: grabbing;
    background-color: #e9ecef;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
}

.task-card:hover {
    background-color: #f7f7f7;
}

.task-card:focus {
    outline: none;
    border-color: #007BFF;
}

/* Responsive Design for Smaller Screens */
@media (max-width: 768px) {
    .task-lists {
        flex-direction: column;
    }

    .task-list-container {
        width: 100%;
    }
}

    </style>
</head>
<body>
    <div class="task-management">
        <h2>Task Management</h2>
        <form id="task-form">
            <input type="text" id="task-title" placeholder="Task Title" required>
            <textarea id="task-desc" placeholder="Task Description"></textarea>
            <button type="button" id="add-task-btn">Add Task</button>
        </form>

        <div class="task-lists">
            <div id="todo" class="task-list-container" data-category="todo">
                <h3>To Do</h3>
                <div class="task-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php if ($row['category'] === 'todo'): ?>
                            <div class="task-item" data-id="<?= htmlspecialchars($row['id']) ?>">
                                <p><?= htmlspecialchars($row['title']) ?></p>
                                <p><?= htmlspecialchars($row['description']) ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>
            </div>
            
            <div id="pending" class="task-list-container" data-category="pending">
                <h3>Pending</h3>
                <div class="task-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php if ($row['category'] === 'pending'): ?>
                            <div class="task-item" data-id="<?= htmlspecialchars($row['id']) ?>">
                                <p><?= htmlspecialchars($row['title']) ?></p>
                                <p><?= htmlspecialchars($row['description']) ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>
            </div>
            
            <div id="done" class="task-list-container" data-category="done">
                <h3>Done</h3>
                <div class="task-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <?php if ($row['category'] === 'done'): ?>
                            <div class="task-item" data-id="<?= htmlspecialchars($row['id']) ?>">
                                <p><?= htmlspecialchars($row['title']) ?></p>
                                <p><?= htmlspecialchars($row['description']) ?></p>
                            </div>
                        <?php endif; ?>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
    <script>
      $(document).ready(function() {
    // Function to initialize or reinitialize drag-and-drop functionality
    function initializeDragAndDrop() {
        $('.task-list').each(function() {
            new Sortable(this, {
                group: 'shared',
                animation: 150,
                onEnd: function(evt) {
                    var taskId = $(evt.item).data('id');
                    var newCategory = $(evt.to).closest('.task-list-container').data('category');

                    console.log('Task ID:', taskId);
                    console.log('New Category:', newCategory);

                    // Update task category via AJAX
                    $.ajax({
                        type: 'POST',
                        url: 'update_task.php',
                        data: { task_id: taskId, task_category: newCategory },
                        success: function(response) {
                            var result = JSON.parse(response);
                            if (result.success) {
                                console.log('Task category updated successfully.');
                            } else {
                                console.log('Error updating task category: ' + result.message);
                            }
                        },
                        error: function() {
                            console.log('Error updating task category.');
                        }
                    });
                }
            });
        });
    }

    // Initialize drag-and-drop on page load
    initializeDragAndDrop();

    $('#add-task-btn').click(function() {
        console.log('Add Task button clicked.');

        var taskTitle = $('#task-title').val().trim();
        var taskDesc = $('#task-desc').val().trim();

        console.log('Task Title:', taskTitle);
        console.log('Task Description:', taskDesc);

        if (taskTitle) {
            $.ajax({
                type: 'POST',
                url: 'add_task.php',
                data: { task_title: taskTitle, task_desc: taskDesc },
                success: function(response) {
                    console.log('Response from server:', response);
                    var result = JSON.parse(response);
                    if (result.success) {
                        alert('Task added successfully.');
                        // Dynamically add the new task to the "To Do" list without reloading the page
                        var newTask = `<div class="task-item" data-id="${result.task_id}">
                                        <p>${taskTitle}</p>
                                        <p>${taskDesc}</p>
                                       </div>`;
                        $('#todo .task-list').append(newTask);
                        // Reinitialize drag-and-drop for the new task
                        initializeDragAndDrop();
                        // Clear the form
                        $('#task-title').val('');
                        $('#task-desc').val('');
                    } else {
                        alert('Error: ' + result.message);
                    }
                },
                error: function() {
                    alert('An error occurred while adding the task.');
                }
            });
        } else {
            alert('Task title is required.');
        }
    });
});


    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
