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