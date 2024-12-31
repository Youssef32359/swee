<?php
include '..\model\DB.php';

// Initialize database connection
$db = new DB();
$conn = $db->getConnection();

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = htmlspecialchars(trim($_POST['title']), ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars(trim($_POST['description']), ENT_QUOTES, 'UTF-8');
    $time = htmlspecialchars(trim($_POST['time']), ENT_QUOTES, 'UTF-8');
    $location = htmlspecialchars(trim($_POST['location']), ENT_QUOTES, 'UTF-8');
    $member_limit = intval($_POST['member_limit']); // Convert to integer
    $created_by = intval($_POST['created_by']); // Convert to integer
    
    // Generate a random event ID (if needed)
    $id = rand(1000, 9999);

    // Prepare the SQL query to insert the event
    $sql = "INSERT INTO events (id, title, description, time, location, member_limit, created_by) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("issssii", $id, $title, $description, $time, $location, $member_limit, $created_by);

        if ($stmt->execute()) {
            $success_message = "New event added successfully with Event ID: " . $id;
        } else {
            $error_message = "Error adding event: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
    } else {
        $error_message = "Failed to prepare the SQL statement.";
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
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

    <a href="dashboard.php#addEvent" class="back-link">Go back to Dashboard</a>
</body>
</html>
