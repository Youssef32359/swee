<?php
session_start(); 
include('header.php');  

require_once '../model/DB.php';  
require_once '../control/UserController.php';  


$db = DB::getInstance();
$conn = $db->getConnection();  


$controller = new UserController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $fullname = trim($_POST['fullname']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);
    $mobile = trim($_POST['mobile']);


    $message = $controller->signup($fullname, $email, $password, $mobile);

   
    echo "<div class='notification-message'>$message</div>"; 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="../public/css/signup.css">
</head>
<body>
    <div class="signup-container">
        <form action="signup.php" method="post">
            <h2>Signup</h2>

            <label for="fullname">Full Name</label>
            <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <label for="mobile">Mobile Number</label>
            <input type="tel" id="mobile" name="mobile" placeholder="Enter your mobile number" required>

            <button type="submit">Sign Up</button>

            <p>Already have an account? <a href="login.php">Login here</a></p>
        </form>
    </div>
</body>
</html>
