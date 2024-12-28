<?php
require_once '../control/ClubLeaderController.php';
require_once '../model/DB.php';
include('header.php');
// Ensure the user is a club leader
// checkRole('club_leader');
session_start();
$db = new DB();
$conn = $db->getConnection();
$clubLeaderController = new ClubLeaderController($conn);
$events = $clubLeaderController->getEventsByCreator($_SESSION['ID']); // Fetch events created by the club leader
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Leader Dashboard</title>
    <link rel="stylesheet" href="../public/css/dashboard.css"> <!-- Link to updated CSS -->
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['FullName']); ?></h1>
        <h2>Your Events</h2>

        <!-- Notification Section -->
        <?php if (isset($_GET['message'])): ?>
            <div class="notification">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <!-- Events Table -->
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Time</th>
                    <th>Location</th>
                    <th>Member Limit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($event = $events->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($event['title']); ?></td>
                        <td><?php echo htmlspecialchars($event['time']); ?></td>
                        <td><?php echo htmlspecialchars($event['location']); ?></td>
                        <td><?php echo htmlspecialchars($event['member_limit']); ?></td>
                        <td class ="actions">
                            <a href="edit_event_clubLeader.php?id=<?php echo $event['id']; ?>">Edit</a>
                            <a href="delete_event_clubLeader.php?id=<?php echo $event['id']; ?>" 
                               onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                            <a href="view_participants.php?id=<?php echo $event['id']; ?>">View Participants</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Create Event Button -->
        <a href="create_event.php" class="btn">Create New Event</a>
    </div>
</body>
</html>