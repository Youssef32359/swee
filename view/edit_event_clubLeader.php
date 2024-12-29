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

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $event = $clubLeaderController->getEventById($event_id);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $time = $_POST['time'];
        $location = $_POST['location'];
        $member_limit = $_POST['member_limit'];

        $message = $clubLeaderController->editEvent($event_id, $title, $description, $time, $location, $member_limit);
        header("Location: club_leader_dashboard.php?message=" . urlencode($message));
        exit;
    }
} else {
    header("Location: club_leader_dashboard.php?message=" . urlencode("Event not found!"));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
    <link rel="stylesheet" href="../public/css/editevent.css">
</head>
<body>
<div class="form-container">
    <h1>Edit Event</h1>
    <form method="POST" class="event-form">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($event['description']); ?></textarea>

        <label for="time">Time</label>
        <input type="datetime-local" id="time" name="time" value="<?php echo htmlspecialchars($event['time']); ?>" required>

        <label for="location">Location</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required>

        <label for="member_limit">Member Limit</label>
        <input type="number" id="member_limit" name="member_limit" value="<?php echo htmlspecialchars($event['member_limit']); ?>" required>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Update Event</button>
            <a href="club_leader_dashboard.php" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
