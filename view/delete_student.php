<?php
include '..\model\DB.php';

$db = new DB();
$conn = $db->getConnection();

$success_message = '';
$id = null;

// Validate and retrieve the user_id from GET or POST
if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
    $id = htmlspecialchars($_POST['user_id'], ENT_QUOTES, 'UTF-8');
} elseif (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $id = htmlspecialchars($_GET['user_id'], ENT_QUOTES, 'UTF-8');
} else {
    echo "<div class='error-message'>User ID not provided or invalid.</div>";
    exit();
}

if ($id) {
    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM users WHERE ID = ?");
    $stmt->bind_param("i", $id); // 'i' for integer binding

    if ($stmt->execute()) {
        // Success message
        $success_message = "User with ID: $id has been deleted successfully.";
    } else {
        // Error during deletion
        echo "<div class='error-message'>Error deleting user: " . htmlspecialchars($stmt->error) . "</div>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <style>
        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-weight: bold;
        }

        .error-message {
            background-color: #f44336;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php if ($success_message): ?>
        <div class="success-message">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>
</body>
</html>
