<?php
session_start();
include('header.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Creation</title>
    <link rel="stylesheet" href="../public/css/manage_activities.css">
</head>
<body>
  
  <div class="container">
      <header>
          <h1>Activity Creation</h1>
      </header>
      <div class="activity-management">
          <h2>Activity Information</h2>
          <form class="activity-form" id="activity-form" onsubmit="return handleSubmit(event)">
              <div class="form-group">
                  <label for="activity-title">Activity Title:</label>
                  <input type="text" id="activity-title" name="activity-title" required>
                  <div class="error-message" id="title-error"></div>
              </div>
              <div class="form-group">
                  <label for="activity-description">Activity Description:</label>
                  <textarea id="activity-description" name="activity-description" required></textarea>
                  <div class="error-message" id="description-error"></div>
              </div>
              <div class="form-group">
                  <label for="activity-location">Activity Location:</label>
                  <input type="text" id="activity-location" name="activity-location" required>
                  <div class="error-message" id="location-error"></div>
              </div>
              <div class="form-group">
                  <label for="activity-date">Activity Date:</label>
                  <input type="date" id="activity-date" name="activity-date" required>
                  <div class="error-message" id="date-error"></div>
              </div>
              <div class="form-group">
                  <label for="activity-time">Activity Time:</label>
                  <input type="time" id="activity-time" name="activity-time" required>
                  <div class="error-message" id="time-error"></div>
              </div>
              <button type="submit" class="submit-btn">Create Activity</button>
              <div class="success-message" id="success-message"></div>
          </form>
      </div>
  </div>

  <script>
      function handleSubmit(event) {
            event.preventDefault(); 

            
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            document.getElementById('success-message').textContent = '';

            
            let isValid = true;
            const title = document.getElementById('activity-title').value.trim();
            const description = document.getElementById('activity-description').value.trim();
            const location = document.getElementById('activity-location').value.trim();
            const date = document.getElementById('activity-date').value;
            const time = document.getElementById('activity-time').value;

            if (!title) {
                document.getElementById('title-error').textContent = 'Title is required.';
                isValid = false;
            }
            if (!description) {
                document.getElementById('description-error').textContent = 'Description is required.';
                isValid = false;
            }
            if (!location) {
                document.getElementById('location-error').textContent = 'Location is required.';
                isValid = false;
            }
            if (!date) {
                document.getElementById('date-error').textContent = 'Date is required.';
                isValid = false;
            }
            if (!time) {
                document.getElementById('time-error').textContent = 'Time is required.';
                isValid = false;
            }

            
            if (isValid) {
                const successMessage = document.getElementById('success-message');
                successMessage.textContent = 'Saved successfully!';
                
            
                setTimeout(() => {
                    successMessage.textContent = '';
                }, 1000);
                
                document.getElementById('activity-form').reset(); 
            }

            return false; 
        }
  </script>
</body>
</html>
