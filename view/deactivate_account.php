<?php
session_start();
require_once '../model/DB.php';

// Check if the user is logged in
if (!isset($_SESSION['ID'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['ID'];
$db = DB::getInstance();
$conn = $db->getConnection();

// Delete the user from the database
$query = "DELETE FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);

if ($stmt->execute()) {
    // Log out the user
    session_destroy();
    echo "<script>
        alert('Your account has been successfully deactivated.');
        window.location.href = 'login.php';
    </script>";
} else {
    echo "<script>
        alert('An error occurred. Please try again.');
        window.location.href = 'profile.php';
    </script>";
}

$stmt->close();
$conn->close();
?>
