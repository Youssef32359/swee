<?php
require_once '../control/ClubLeaderController.php';
require_once '../model/DB.php';
include('header.php');

// Ensure the user is a club leader
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
    <link rel="stylesheet" href="../public/css/clubleader.css"> <!-- Link to updated CSS -->
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['FullName']); ?></h1>
            <h2>Your Events</h2>
        </div>

        <!-- Notification Section -->
        <?php if (isset($_GET['message'])): ?>
            <div class="notification">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <!-- Events Table -->
        <?php if ($events->num_rows > 0): ?>
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
                            <td><?php echo date('D, d M Y h:i A', strtotime($event['time'])); ?></td>
                            <td><?php echo htmlspecialchars($event['location']); ?></td>
                            <td><?php echo htmlspecialchars($event['member_limit']); ?></td>
                            <td class="actions">
                                <a href="edit_event_clubLeader.php?id=<?php echo $event['id']; ?>" class="btn edit">Edit</a>
                                <a href="delete_event_clubLeader.php?id=<?php echo $event['id']; ?>" class="btn delete"
                                   onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                                <a href="view_participants.php?id=<?php echo $event['id']; ?>" class="btn view">View Participants</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-events">You have not created any events yet.</p>
        <?php endif; ?>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="create_event.php" class="btn create">Create New Event</a>
            <a href="propose_event.php" class="btn propose">Propose Events for Voting</a>
        </div>
    </div>
</body>
</html>
