<?php
include('header.php');  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Reminders and Updates</title>
  <link rel="stylesheet" href="style.css">
</head>
<style>

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body {
    font-family: Arial, sans-serif;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-image: url('../images/18392.jpg'); 
    background-size: cover; 
    background-position: center; 
}



header {
  background-color: #1a2130;
  color: #fff;
  padding: 20px;
  text-align: center;
}

header h1 {
  font-size: 24px;
}

main {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.event-list,
.notification-settings {
  background-color: #3e4a5b;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 20px;
  margin-bottom: 20px;
}

.event-card {
  border: 1px solid white;
  border-radius: 5px;
  padding: 10px;
  margin-bottom: 10px;
}

.event-card h3 {
  font-size: 18px;
  margin-bottom: 5px;
}

.event-card p {
  margin-bottom: 5px;
}

.remind-me-btn {
  background-color: #5a72a0;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 5px 10px;
  cursor: pointer;
}

.remind-me-btn:hover {
  background-color: #83b4ff;
}

.notification-form .form-group {
  margin-bottom: 10px;
}

.notification-form label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.checkbox-group {
  display: flex;
  align-items: center;
}

.checkbox-group input[type="checkbox"] {
  margin-right: 5px;
}

.save-btn {
  background-color: #5a72a0;
  color: #fff;
  border: none;
  border-radius: 5px;
  padding: 10px 20px;
  cursor: pointer;
}

.save-btn:hover {
  background-color: #83b4ff;
}

footer {
  background-color: #1a2130;
  color: #fff;
  padding: 10px;
  text-align: center;
}
</style>
<body>
  <header>
    <h1>Upcoming Events</h1>
  </header>

  <main>
    <section class="event-list">
      <div class="event-card">
        <h2>Spring Festival</h2><br>
        <p>Celebrate the arrival of spring with food, games, and entertainment!</p>
        <p>Date: <span class="event-date">2024-04-20</span></p>
        <p>Time: <span class="event-time">12:00</span></p>
        <p>Location: <span class="event-location">Campus Quad</span></p>
        <a href="/view/notifications.php">
        <button class="remind-me-btn">Remind Me</button>
        </a>
      </div>
      </section>
      <section class="event-list">
      <div class="event-card">
        <h3>Career Fair</h3>
        <p>Connect with local businesses and explore job and internship opportunities.</p>
        <p>Date: <span class="event-date">2024-02-15</span></p>
        <p>Time: <span class="event-time">11:00</span></p>
        <p>Location: <span class="event-location">Gymnasium</span></p>
        <a href="/view/notifications.php">
       <button class="remind-me-btn">Remind Me</button>
       </a>
      </div>
    </section>
    <section class="event-list">
      <div class="event-card">
        <h3>Book Fair</h3>
        <p>Explore new books, meet authors, and enjoy discounts at our annual book fair.</p>
        <p>Date: <span class="event-date">2024-01-25</span></p>
        <p>Time: <span class="event-time">09:00</span></p>
        <p>Location: <span class="event-location">Library Hall</span></p>
        <a href="/view/notifications.php">
        <button class="remind-me-btn">Remind Me</button>
        </a>
      </div>

    </section>
  </main>

</body>
</html>