<?php
include '../model/DB.php'; 

$db = new DB();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_POST['event_name'];
    $event_date = $_POST['event_date'];
    
    $event_id = rand(1000, 9999);  

    $sql = "INSERT INTO events (ID, EventName, EventDate) VALUES ('$event_id', '$event_name', '$event_date')";

    if ($conn->query($sql) === TRUE) {
        echo "New event added successfully with Event ID: " . $event_id;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>
