<?php
require_once '../control/ClubLeaderController.php';
require_once '../model/DB.php';
// Ensure the user is a club leader
// checkRole('club_leader');
session_start();
$db = new DB();
$conn = $db->getConnection();
$clubLeaderController = new ClubLeaderController($conn);

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Delete the event
    $message = $clubLeaderController->deleteEvent($event_id);
    header("Location: club_leader_dashboard.php?message=" . urlencode($message));
    exit;
} else {
    header("Location: club_leader_dashboard.php?message=" . urlencode("Event ID not provided."));
    exit;
}