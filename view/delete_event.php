<?php
require_once '../model/DB.php';  

// Initialize database connection
$db = new DB();
$conn = $db->getConnection(); 

$success_message = '';
$error_message = '';

// Check if the event ID is provided
if (isset($_POST['event_id']) && !empty($_POST['event_id'])) {
    $event_id = intval($_POST['event_id']); // Convert the ID to an integer for safety

    // Prepare the DELETE query
    $query = "DELETE FROM events WHERE ID = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $event_id);

        if ($stmt->execute()) {
            // If deletion is successful, display a success message
            $success_message = "Event with ID: $event_id has been deleted successfully.";
        } else {
            // Display an error if deletion fails
            $error_message = "Error deleting event: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    } else {
        $error_message = "Failed to prepare the DELETE statement.";
    }
} else {
    $error_message = "Event ID is required for deletion!";
}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Event</title>
    <style>
        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            margin: 20px auto;
            border-radius: 5px;
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-weight: bold;
            max-width: 500px;
        }

        .error-message {
            background-color: #f44336;
            color: white;
            padding: 15px;
            margin: 20px auto;
            border-radius: 5px;
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-weight: bold;
            max-width: 500px;
        }

        .back-link {
            display: block;
            margin: 20px auto;
            text-align: center;
            font-size: 16px;
            color: #0056b3;
            text-decoration: none;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php if (!empty($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php elseif (!empty($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>

    <a href="dashboard.php#viewEvents" class="back-link">Go back to Dashboard</a>
</body>
</html>
