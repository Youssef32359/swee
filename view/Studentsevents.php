<?php
session_start();
require_once '../model/DB.php';

// Ensure user is logged in
if (!isset($_SESSION['ID'])) {
    echo "<script>
        alert('Please log in to view your registered events.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

$user_id = $_SESSION['ID'];
$db = new DB();
$conn = $db->getConnection();

// Fetch registered events for the logged-in user
$query = "
    SELECT events.title, events.description, events.time, events.location
    FROM participants
    INNER JOIN events ON participants.event_id = events.id
    WHERE participants.user_id = ?
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Events</title>
    <link rel="stylesheet" href="../public/css/myevents.css"> <!-- Link to your CSS file -->
    <style>
        /* Inline CSS for simplicity */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 28px;
            color: #333;
        }
        .event {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #f9f9f9;
        }
        .event h3 {
            margin: 0;
            color: #444;
        }
        .event p {
            margin: 5px 0;
            color: #666;
        }
        .no-events {
            text-align: center;
            color: #888;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>My Registered Events</h1>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="event">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p><strong>Date:</strong> <?php echo date('F j, Y, g:i A', strtotime($row['time'])); ?></p>
                    <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-events">You have not registered for any events yet.</p>
        <?php endif; ?>

    </div>
</body>
</html>
