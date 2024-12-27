<?php
include '..\model\DB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $query = "SELECT * FROM events WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html>
<body>
    
    <form action="save_event.php" method="post">
        <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
        <label>Event Name:</label>
        <input type="text" name="event_name" value="<?php echo $event['name']; ?>" required>
        <label>Event Date:</label>
        <input type="date" name="event_date" value="<?php echo $event['date']; ?>" required>
        <button type="submit">Save Changes</button>
    </form>
</body>
</html>
