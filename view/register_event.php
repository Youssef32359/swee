<?php
session_start();
require_once '../model/DB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure user is logged in
    if (!isset($_SESSION['ID'])) {
        header("Location: ../view/login.php");
        exit;
    }

    $user_id = $_SESSION['ID'];
    $event_id = $_POST['event_id'];

    $db = DB::getInstance();
    $conn = $db->getConnection();

    // Check if the user is already registered for the event
    $query = "SELECT * FROM participants WHERE event_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: eventregistration.php?message=" . urlencode("You are already registered for this event."));
        exit;
    }

    // Register the user for the event
    $query = "INSERT INTO participants (event_id, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $event_id, $user_id);

    if ($stmt->execute()) {
        header("Location: eventregistration.php?message=" . urlencode("Successfully registered for the event."));
        exit;
    } else {
        header("Location: eventregistration.php?message=" . urlencode("Error registering for the event."));
        exit;
    }
}