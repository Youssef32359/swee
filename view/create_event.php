<?php
require_once '../control/ClubLeaderController.php';
require_once '../model/DB.php';
include('header.php');
include('sidebar.php');


$db = DB::getInstance();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $member_limit = $_POST['member_limit'];
    $created_by = $_SESSION['ID'];

    $clubLeaderController = new ClubLeaderController($conn);
    $message = $clubLeaderController->createEvent($title, $description, $time, $location, $member_limit, $created_by);
    header("Location: club_leader_dashboard.php?message=" . urlencode($message));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link rel="stylesheet" href="../public/css/createevent.css">
</head>
<body>
<div class="form-container">
    <h1>Create New Event</h1>
    <form method="POST" class="event-form">
        <label for="title">Title</label>
        <input type="text" id="title" name="title" placeholder="Enter event title" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" placeholder="Enter event description" rows="4" required></textarea>

        <label for="time">Time</label>
        <input type="datetime-local" id="time" name="time" required>

        <label for="location">Location</label>
        <input type="text" id="location" name="location" placeholder="Enter event location" required>

        <label for="member_limit">Member Limit</label>
        <input type="number" id="member_limit" name="member_limit" placeholder="Enter member limit" required>

        <button type="submit" class="btn">Create Event</button>
    </form>
</div>
</body>
</html>
