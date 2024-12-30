<?php
session_start();
require_once '../model/DB.php';

// Check if the user is logged in
if (!isset($_SESSION['ID'])) {
    echo "<script>
        alert('Please log in or sign up to access your profile.');
        window.location.href = 'login.php';
    </script>";
    exit;
}

$userId = $_SESSION['ID'];

// Fetch user details from the database
$db = new DB();
$conn = $db->getConnection();
$stmt = $conn->prepare("SELECT fullname, email, mobile, created_at, role FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $fullName = $user['fullname'];
    $email = $user['email'];
    $mobileNumber = $user['mobile'];
    $createdAt = $user['created_at'];
    $role = $user['role'];
} else {
    echo "<script>alert('User not found. Please log in again.');</script>";
    header("Location: login.php");
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="../public/css/profile.css"> <!-- Link to your CSS file -->
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        .profile-container {
            max-width: 800px;
            margin: 50px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .profile-header h1 {
            font-size: 28px;
            color: #333;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .profile-info-item {
            display: flex;
            justify-content: space-between;
            background-color: #f9f9f9;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .profile-info-item strong {
            color: #555;
            font-size: 16px;
        }

        .profile-info-item span {
            color: #333;
            font-size: 16px;
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn-container a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-container a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="profile-container">
        <div class="profile-header">
            <h1>Welcome, <?php echo htmlspecialchars($fullName); ?>!</h1>
        </div>
        
        <div class="profile-info">
            <div class="profile-info-item">
                <strong>Full Name:</strong>
                <span><?php echo htmlspecialchars($fullName); ?></span>
            </div>
            <div class="profile-info-item">
                <strong>Email:</strong>
                <span><?php echo htmlspecialchars($email); ?></span>
            </div>
            <div class="profile-info-item">
                <strong>Mobile Number:</strong>
                <span><?php echo htmlspecialchars($mobileNumber); ?></span>
            </div>
            <div class="profile-info-item">
                <strong>Account Created On:</strong>
                <span><?php echo date('F j, Y', strtotime($createdAt)); ?></span>
            </div>
            <div class="profile-info-item">
                <strong>Role:</strong>
                <!-- Adjusting the Role Display -->
                <span><?php echo htmlspecialchars($role === 'user' ? 'Student' : ucfirst($role)); ?></span>
            </div>
        </div>

        <div class="btn-container">
            <a href="../index.php">Back to Dashboard</a>
        </div>
    </div>

</body>
</html>
