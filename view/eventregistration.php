<?php
session_start();
include('header.php');

// Database connection
require_once '../model/DB.php';
$db = new DB();
$conn = $db->getConnection();

// Fetch events from the database
$query = "SELECT id, title, time, location, member_limit, 
                 (SELECT COUNT(*) FROM participants WHERE participants.event_id = events.id) AS registered_count 
          FROM events";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration Calendar</title>
    <link rel="stylesheet" href="../public/css/eventregistration.css">
</head>
<body>

    <div class="container">
      
        <header>
            <h1>Event Registration Calendar</h1>
        </header>
        
        <div class="calendar">
            <?php
            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    $available_spots = $row['member_limit'] - $row['registered_count'];
            ?>
            <div class="day">
                <h2><?php echo date('D, d M', strtotime($row['time'])); ?></h2>
                <div class="event">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p class="spots">Available spots: <?php echo $available_spots . '/' . $row['member_limit']; ?></p>
                    
                    <?php if ($available_spots > 0): ?>
                        <form method="POST" action="register_event.php">
                            <input type="hidden" name="event_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" class="register-btn">Register</button>
                        </form>
                    <?php else: ?>
                        <button class="register-btn disabled" disabled>Full</button>
                    <?php endif; ?>
                </div>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <p>No events available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>