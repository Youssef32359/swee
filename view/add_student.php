<?php
include '../model/DB.php';
session_start();
// Establish database connection
$db = new DB();
$conn = $db->getConnection();

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash password before storing
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];

    // Validate role to match allowed ENUM values
    $allowed_roles = ['user', 'admin', 'club_leader'];
    if (!in_array($role, $allowed_roles)) {
        $error_message = "Invalid role selected.";
    } else {
        // Insert into users table
        $sql = "INSERT INTO users (fullname, email, password, mobile, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("sssss", $fullname, $email, $password, $mobile, $role);
            try {
                if ($stmt->execute()) {
                    $success_message = "New user added successfully!";
                } else {
                    throw new Exception($stmt->error);
                }
            } catch (Exception $e) {
                if (strpos($e->getMessage(), 'Duplicate entry') !== false) {
                    $error_message = "The email <strong>" . htmlspecialchars($email) . "</strong> is already registered. Please use a different email or update the existing record.";
                } else {
                    $error_message = "Error: " . htmlspecialchars($e->getMessage());
                }
            }
            $stmt->close();
        } else {
            $error_message = "Error preparing statement: " . htmlspecialchars($conn->error);
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <style>
        .success-message, .error-message {
            text-align: center;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 16px;
        }
        .success-message {
            background-color: #4CAF50;
            color: white;
        }
        .error-message {
            background-color: #f44336;
            color: white;
        }
        .error-message strong {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <?php if ($success_message): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <?php if ($error_message): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
</body>
</html>
