<?php
require_once '../model/DB.php';  


$db = new DB();
$conn = $db->getConnection(); 


if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    
    $query = "DELETE FROM events WHERE ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();

    
    header("Location: dashboard.php#viewEvents");
    exit();
} else {
    die("Event ID is required for deletion!");
}


$db->closeConnection();
?>
