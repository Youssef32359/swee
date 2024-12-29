<?php
require_once 'model/DB.php'; 


$db = new DB();
$conn = $db->getConnection();  

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    
    $query = "UPDATE users SET is_verified = 1 WHERE token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);

    if ($stmt->execute()) {
        $message = "Your email has been verified successfully!";
        $messageType = "success";
    } else {
        $message = "Verification failed. Please try again.";
        $messageType = "error";
    }
} else {
    $message = "Invalid token.";
    $messageType = "error";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="public/css/verify_email.css"> 
    <style>
      
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #F0F0F0;
            color: #333; 
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #3E4A5B; 
            color: #FFFFFF; 
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            text-align: center; 
            width: 80%; 
            max-width: 400px; 
        }

        h1 {
            margin-bottom: 20px;
        }

        .message {
            margin: 20px 0;
            font-size: 1.2rem; 
        }

        .success {
            color: green; 
        }

        .error {
            color: red; 
        }

        a {
            color: #5A72A0; 
            text-decoration: none; 
            font-weight: bold; 
        }

        a:hover {
            text-decoration: underline; 
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Email Verification</h1>
    <div class="message <?php echo $messageType; ?>">
        <?php echo $message; ?>
    </div>
    <a href="\swee\view\login.php">Go to Login</a> 
</div>

</body>
</html>
