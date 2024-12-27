<?php
require_once '../model/DB.php';  
require_once '../control/UserController.php';  

include('header.php');  
error_reporting(E_ALL);   
ini_set('display_errors', 1); 

session_start();  


$db = new DB();
$conn = $db->getConnection();  


$controller = new UserController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

   
    $message = $controller->login($email, $password);

    
    if (isset($_SESSION['ID'])) {
        
        $_SESSION['user_id'] = $_SESSION['ID'];  
        $_SESSION['role'] = $controller->getUserRole($_SESSION['ID']); 

       
        if ($_SESSION['role'] === 'admin') {
            header("Location: ../view/dashboard.php");  
        } else {
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
