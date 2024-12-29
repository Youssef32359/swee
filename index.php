<?php
require 'vendor/autoload.php';

include('view/sidebar.php');
include('view/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Activity Management</title>
    <link rel="stylesheet" href="public/css/index.css"> 
    <style>
    
    .hero {
    position: relative;
    width: 100%;
    height: 300px; 
    overflow: hidden; 
    color: white; 
    text-align: center; 
    padding: 20px; 
}


.slideshow-container {
    position: absolute; 
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1; 
}

.mySlides {
    display: none; 
    width: 100%;
    height: 100%; 
}

.mySlides img {
    width: 100%;
    height: 100%; 
    object-fit: cover; 
}

.hero h1, .hero p {
    position: relative; 
    z-index: 2; 
}


.dots-container {
    position: absolute; 
    bottom: 20px; 
    left: 50%; 
    transform: translateX(-50%); 
    z-index: 3; 
    display: flex; 
}

.dot {
    height: 15px;
    width: 15px;
    margin: 0 2px;
    background-color: white;
    border-radius: 50%;
    display: inline-block;
    cursor: pointer;
    opacity: 0.6;
}

.active {
    opacity: 1; 
}

.prev, .next {
    display: none; 
}
    /* Ensure content doesn't overlap with the sidebar and toggle button */
    body {
        margin-left: 0;  /* No margin initially */
        transition: margin-left 0.3s ease; /* Smooth transition for body content */
    }

    /* When sidebar is shown, shift the body content to the right */
    body.sidebar-visible {
        margin-left: 250px;  /* Adjust this to match the sidebar width */
    }

    /* Hero Section */
    .hero {
        margin-left: 0; /* Ensure the hero section starts on the left */
        padding-top: 60px; /* Add padding to the top to avoid overlap with the toggle button */
    }

    /* Adjust margins for other sections similarly */
    .activities, .calendar-section, .resources {
        margin-left: 0;  /* Make sure sections don't overlap the sidebar */
        padding-top: 20px;
    }

</style>
</head>
<body>
  
<!-- Toggle Button (in the header or top left corner) -->
<button class="sidebar-toggle-btn" onclick="toggleSidebar()">☰</button>

<div class="hero">
    <h1>Engage, Participate, Excel</h1>
    <p>Join the best extracurricular activities for growth</p>
   
    <div class="slideshow-container">
       
        <div class="mySlides">
            <img src="public\images\students-activity.jpg" alt="Students Activity">
        </div>
        <div class="mySlides">
            <img src="public\images\robotics.jpg" alt="Campus Life">
        </div>
        <div class="mySlides">
            <img src="public\images\cooking.jpg" alt="Student Club">
        </div>

        <!-- Dots for navigation -->
        <div class="dots-container">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
        </div>

        <button onclick="scrollToActivities()">Join an Activity</button>
    </div>
</div>


<section class="activities" id="activities">
    <h2>Upcoming Activities</h2>
    <div class="activity-grid">
      <div class="activity-card">
        <img src="public/images/students-activity.jpg" alt="Art Workshop">
        <h3>Art Workshop</h3>
        <p>Nov 1st, 2:00 PM</p>
        <button>Register</button>
      </div>
      <div class="activity-card">
        <img src="public/images/robotics.jpg" alt="Robotics Meetup">
        <h3>Robotics Meetup</h3>
        <p>Nov 2nd, 3:00 PM</p>
        <button>Register</button>
      </div>
      <div class="activity-card">
        <img src="public\images\cooking.jpg" alt="Cooking Class">
        <h3>Cooking Class</h3>
        <p>Nov 3rd, 5:00 PM</p>
        <button>Register</button>
      </div>
    </div>
</section>


<section class="calendar-section">
    <h2>Events Calendar</h2>
    <div class="calendar">
      <h3>October 2024</h3>
      
    </div>
    <div class="event-list">
      <h3>Upcoming Events</h3>
      <p>Music Festival - Nov 5th, 4:00 PM</p>
      <p>Photography Contest - Nov 7th, 1:00 PM</p>
      <p>Chess Tournament - Nov 10th, 10:00 AM</p>
    </div>
</section>


<section class="resources">
    <h2>Resources</h2>
    <div class="resource-items">
      <div class="resource-item">
        <h3>Student Handbook</h3>
        <a href="#">Download PDF</a>
      </div>
      <div class="resource-item">
        <h3>Event Planning Guide</h3>
        <a href="#">Download PDF</a>
      </div>
      <div class="resource-item">
        <h3>Volunteer Guide</h3>
        <a href="#">Download PDF</a>
      </div>
    </div>
</section>


<section class="testimonials">
 
</section>


<footer>
    <p>© 2024 Student Activity Management System</p>
</footer>

<script>
function scrollToActivities() {
    document.getElementById('activities').scrollIntoView({ behavior: 'smooth' });
}

let slideIndex = 0;
showSlides();

function showSlides() {
    let i;
    let slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"; 
    }
    
    slideIndex++;
    if (slideIndex > slides.length) {slideIndex = 1} 
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", ""); 
    }
    
    slides[slideIndex - 1].style.display = "block"; 
    dots[slideIndex - 1].className += " active"; 
    setTimeout(showSlides, 5000); 
}

function currentSlide(n) {
    showSlidesByIndex(slideIndex = n);
}

function showSlidesByIndex(n) {
    let i, slides = document.getElementsByClassName("mySlides");
    let dots = document.getElementsByClassName("dot");
    
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"; 
    }
    
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", ""); 
    }
    
    slides[slideIndex - 1].style.display = "block"; 
    dots[slideIndex - 1].className += " active"; 
}
</script>


<script>
        // Function to toggle sidebar visibility
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('sidebar-hidden');  // Toggle the sidebar-hidden class
        }

        // Toggle dropdowns when clicked
        const dropdownBtns = document.querySelectorAll('.dropdown-btn');
        dropdownBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const parentItem = btn.parentElement;
                parentItem.classList.toggle('active');
            });
        });
    </script>
</body>
</html>
