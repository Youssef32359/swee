<?php
require_once '../model/DB.php';
include('header.php');

session_start();
$db = new DB();
$conn = $db->getConnection();

// Fetch proposed events from the database
$query = "SELECT id, title, time, location, member_limit, vote_count FROM proposed_events";
$result = $conn->query($query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Voting</title>
    <link rel="stylesheet" href="../public/css/eventregistration.css">
</head>
<body>

    <div class="container">
      
        <header>
            <h1>Event Voting</h1>
        </header>
        
        <div class="calendar">
            <?php
            if ($result && $result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    $available_spots = $row['member_limit'];
            ?>
            <div class="day">
                <h2><?php echo date('D, d M', strtotime($row['time'])); ?></h2>
                <div class="event">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p class="spots">Votes: <?php echo $row['vote_count']; ?></p>
                    <p>Location: <?php echo htmlspecialchars($row['location']); ?></p>
                    
                    <form method="POST" action="submit_vote.php">
                        <input type="hidden" name="vote" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="register-btn">Vote</button>
                    </form>
                </div>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <p>No events available for voting at the moment.</p>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>