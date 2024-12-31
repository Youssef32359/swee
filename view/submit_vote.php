<?php
require_once '../model/DB.php';
session_start();
if (!isset($_SESSION['ID'])) {
    // Redirect to the login page with a message
    header("Location: login.php?message=Please log in to vote.");
    exit; // Ensure no further code runs after the redirect
}
$db = DB::getInstance();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_SESSION['ID'];
    $proposed_event_id = $_POST['vote'];

    // Check if the student already voted
    $checkVoteSql = "SELECT * FROM votes WHERE student_id = ? AND proposed_event_id = ?";
    $stmt = $conn->prepare($checkVoteSql);
    $stmt->bind_param("ii", $student_id, $proposed_event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: ../index.php?message=You already voted!");
        exit;
    }

    // Submit vote
    $voteSql = "INSERT INTO votes (student_id, proposed_event_id) VALUES (?, ?)";
    $stmt = $conn->prepare($voteSql);
    $stmt->bind_param("ii", $student_id, $proposed_event_id);
    if ($stmt->execute()) {
        // Update vote count
        $updateVoteCountSql = "UPDATE proposed_events SET vote_count = vote_count + 1 WHERE id = ?";
        $stmt = $conn->prepare($updateVoteCountSql);
        $stmt->bind_param("i", $proposed_event_id);
        $stmt->execute();

        header("Location: ../index.php?message=Vote submitted successfully!");
    } else {
        header("Location: ../index.php?message=Failed to submit vote.");
    }
}