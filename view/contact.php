<?php
session_start();
require_once '../model/DB.php';  

error_reporting(E_ALL);  
ini_set('display_errors', 1); 


$db = new DB();
$conn = $db->getConnection();  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

   
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $subject, $message); 

    if ($stmt->execute()) {
    
        $successMessage = "Thank you! Your message has been sent successfully.";
    } else {
        
        $errorMessage = "Error: " . $stmt->error;
    }

    $stmt->close(); 
    $conn->close(); 
}

include('header.php'); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="../public/css/contact.css">
</head>
<body>
  
  <div class="container">
      <header>
          <h1>Contact Us</h1>
      </header>
      <div class="contact-info">
          <p><strong>Email:</strong> MIUEGYPT@GMAIL.COM</p>
          <p><strong>Phone:</strong> 01002403290</p>
          <p><strong>Office Address:</strong> Obour City , Qalyubiyya Governorate 30.167°N 31.492°E</p>
      </div>
      <div class="contact-management">
          <h2>Send Us a Message</h2>
          <form class="contact-form" id="contact-form" action="contact.php" method="post">
              <div class="form-group">
                  <label for="name">Name:</label>
                  <input type="text" id="name" name="name" required>
                  <div class="error-message" id="name-error"></div>
              </div>
              <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" id="email" name="email" required>
                  <div class="error-message" id="email-error"></div>
              </div>
              <div class="form-group">
                  <label for="subject">Subject:</label>
                  <input type="text" id="subject" name="subject" required>
                  <div class="error-message" id="subject-error"></div>
              </div>
              <div class="form-group">
                  <label for="message">Message:</label>
                  <textarea id="message" name="message" rows="4" required></textarea>
                  <div class="error-message" id="message-error"></div>
              </div>
              <button type="submit" class="submit-btn">Send Message</button>
              <div class="success-message" id="contact-success-message">
                  <?php if (isset($successMessage)) echo $successMessage; ?>
                  <?php if (isset($errorMessage)) echo $errorMessage; ?>
              </div>
          </form>
      </div>
  </div>

</body>
</html>
