<?php
include('header.php');  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notification Preferences</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    header {
      background-color: #1a2130;
      color: #fff;
      padding: 8px;
      text-align: center;
    }

    .form-container {
      max-width: 500px;
      margin: 20px auto;
      background-color: #3e4a5b;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      color: white;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    input, select {
      width: 100%;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    button {
      background-color: #007bff;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <header>
    <h1>Reminders</h1>
  </header>

  <div class="form-container">
    <form id="notification-preferences-form">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="phone-number">Phone Number:</label>
        <input type="tel" id="phone-number" name="phone-number" pattern="[0-9]{11}" title="Phone number must be 11 digits" required>
      </div>
      <div class="form-group">
        <label>Notification Methods:</label>
        <div>
          <input type="checkbox" id="email-notification" name="notification-methods" value="email">
          <label for="email-notification">Email</label>
        </div>
        <div>
          <input type="checkbox" id="sms-notification" name="notification-methods" value="sms">
          <label for="sms-notification">SMS</label>
        </div>
      </div>
      <div class="form-group">
        <label for="notification-frequency">Notification Frequency:</label>
        <select id="notification-frequency" name="notification-frequency" required>
          <option value="1week">1 week before</option>
          <option value="3days">3 days before</option>
          <option value="1day">1 day before</option>
        </select>
      </div>
      <button type="submit">Save Preferences</button>
    </form>
  </div>

  <script>
    document.getElementById('notification-preferences-form').addEventListener('submit', function(event) {
      event.preventDefault(); 

     
      const email = document.getElementById('email').value;
      const phoneNumber = document.getElementById('phone-number').value;
      const notificationMethods = Array.from(document.querySelectorAll('input[name="notification-methods"]:checked'))
        .map((checkbox) => checkbox.value);

      
      if (phoneNumber.length !== 11) {
        alert('Phone number must be 11 digits.');
        return;
      }

      if (notificationMethods.length === 0) {
        alert('Please select at least one notification method.');
        return;
      }

      
      const notificationFrequency = document.getElementById('notification-frequency').value;
      const preferenceData = {
        email,
        phoneNumber,
        notificationMethods,
        notificationFrequency
      };

   
      console.log('Preferences saved:', preferenceData);
      alert('Preferences saved successfully!');
    });
  </script>
</body>
</html>