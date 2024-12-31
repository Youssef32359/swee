<?php
require_once '../model/DB.php';  
require_once '../control/UserController.php';  


include('header.php');  
error_reporting(E_ALL);   
ini_set('display_errors', 1); 

session_start();  

$db = DB::getInstance();
$conn = $db->getConnection();  
$controller = new UserController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));

    // Process login
    $message = $controller->login($email, $password);

    // Handle login success or error message
    if (isset($_SESSION['ID'])) {
        $_SESSION['user_id'] = $_SESSION['ID'];
        $_SESSION['role'] = $_SESSION['role']; 

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
        echo "<div class='notification-message error'>$message</div>";
    }
}
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
    </div>
</body>
</html>