<?php
require_once '../model/DB.php';  
require_once '../control/UserController.php';  

include('header.php');  
error_reporting(E_ALL);   
ini_set('display_errors', 1); 

session_start();  

$db = new DB();
$conn = $db->getConnection();  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Retrieve user from the database
    $sql = "SELECT id, fullname, email, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify hashed password
            if (password_verify($password, $user['password'])) {
                // Store session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['role'] = $user['role'];

                // Redirect based on role
                switch ($_SESSION['role']) {
                    case 'admin':
                        header("Location: ../view/dashboard.php");
                        break;
                    case 'club_leader':
                        header("Location: ../view/club_leader_dashboard.php");
                        break;
                    default:
                        header("Location: ../index.php");
                }
                exit;
            } else {
                $message = "Invalid email or password.";
            }
        } else {
            $message = "No account found with this email.";
        }
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../public/css/signup.css">
</head>
<body>
    <div class="signup-container">
        <form action="login.php" method="post">
            <h2>Login</h2>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>

            <p>Don't have an account? <a href="signup.php">Signup here</a></p>
        </form>
        <?php if (isset($message)): ?>
            <div class="notification-message error"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
