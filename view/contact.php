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

      <!-- Google Map Section -->
      <!-- Google Map Section -->
<!-- Google Map Section -->
<div class="google-map">
    <div class="map-info">
        <h2>Our Location</h2>
    </div>
    <!-- Static Google Map -->
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3449.4033462569705!2d31.489390974799083!3d30.16847011268514!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14581bab30f3291d%3A0x1b138aefe2d8bedb!2sMisr%20International%20University%20(MIU)!5e0!3m2!1sen!2seg!4v1722692650778!5m2!1sen!2seg" width="500" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
<style>
    /* Centering the Google Map */
/* Google Map Section with Text on the Left */
.google-map {
    display: flex; /* Align the text and map side by side */
    justify-content: center; /* Center content horizontally */
    align-items: center; /* Center content vertically */
    margin: 30px auto; /* Margin around the section */
    width: 80%; /* Width of the container */
    text-align: left; /* Align the text to the left */
}

.map-info {
    flex: 1; /* Take up remaining space */
    padding-right: 20px; /* Add space between the text and the map */
}

.google-map iframe {
    width: 600px; /* Make the map larger */
    height: 400px; /* Make the map larger */
    border: none; /* Remove the default border */
    border-radius: 10px; /* Rounded corners */
    box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1); /* Optional: add shadow to the map */
}

.map-info h2 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 10px;
}

</style>