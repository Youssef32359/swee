<?php
session_start();
include('header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registration Calendar</title>
    <link rel="stylesheet" href="../public/css/eventregistration.css"> 
</head>
<body>

    <div class="container">
      
        <header class="aaa">
            <h1>Event Registration Calendar</h1>
        </header>

        
        <div class="calendar">
          
            <div class="day">
                <h2>Mon, 1</h2>
                <div class="event">
                    <h3>Art Workshop</h3>
                    <p class="spots">Available spots: 10/20</p>
                    <button class="register-btn">Register</button>
                </div>
            </div>

            <div class="day">
                <h2>Tue, 2</h2>
                <div class="event">
                    <h3>Robotics Meetup</h3>
                    <p class="spots">Available spots: 5/15</p>
                    <button class="register-btn">Register</button>
                </div>
            </div>

            <div class="day">
                <h2>Wed, 3</h2>
                <div class="event">
                    <h3>Cooking Class</h3>
                    <p class="spots">Available spots: 7/10</p>
                    <button class="register-btn">Register</button>
                </div>
            </div>

            <div class="day">
                <h2>Thu, 4</h2>
                <div class="event">
                    <h3>Drama Club</h3>
                    <p class="spots">Available spots: 2/12</p>
                    <button class="register-btn">Register</button>
                </div>
            </div>

            <div class="day">
                <h2>Fri, 5</h2>
                <div class="event">
                    <h3>Soccer Game</h3>
                    <p class="spots">Available spots: 12/25</p>
                    <button class="register-btn">Register</button>
                </div>
            </div>

            <div class="day">
                <h2>Sat, 6</h2>
                <div class="event">
                    <h3>Music Festival</h3>
                    <p class="spots">Available spots: 8/30</p>
                    <button class="register-btn">Register</button>
                </div>
            </div>

            <div class="day">
                <h2>Sun, 7</h2>
                <div class="event">
                    <h3>Photography Contest</h3>
                    <p class="spots">Available spots: 3/15</p>
                    <button class="register-btn">Register</button>
                </div>
            </div>

            <div class="day">
                <h2>Mon, 8</h2>
                <div class="event">
                    <h3>Science Fair</h3>
                    <p class="spots">Available spots: 9/20</p>
                    <button class="register-btn">Register</button>
                </div>
            </div>

            <div class="day">
                <h2>Tue, 9</h2>
                <div class="event">
                    <h3>Book Club</h3>
                    <p class="spots">Available spots: 6/12</p>
                    <button class="register-btn">Register</button>
                </div>
            </div>

            <div class="day">
                <h2>Wed, 10</h2>
                <div class="event">
                    <h3>Chess Tournament</h3>
                    <p class="spots">Available spots: 4/16</p>
                    <button class="register-btn">Register</button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>