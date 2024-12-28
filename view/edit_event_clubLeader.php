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

        $message = $clubLeaderController->editEvent($event_id, $title, $description,  $time, $location, $member_limit);
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
    <link rel="stylesheet" href="../public/css/event.css">
</head>
<body>
    <div class="container">
    <h1>Edit Event</h1>
    <form method="POST">
        <label>Title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required><br>

        <label>Description:</label>
        <textarea name="description" required><?php echo htmlspecialchars($event['description']); ?></textarea><br>

        <label>Time:</label>
        <input type="datetime-local" name="time" value="<?php echo htmlspecialchars($event['time']); ?>" required><br>

        <label>Location:</label>
        <input type="text" name="location" value="<?php echo htmlspecialchars($event['location']); ?>" required><br>

        <label>Member Limit:</label>
        <input type="number" name="member_limit" value="<?php echo htmlspecialchars($event['member_limit']); ?>" required><br>

        <button type="submit">Update Event</button>
    </form>
    </div>
</body>
</html>