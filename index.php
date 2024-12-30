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
    <link rel="stylesheet" href="public/css/sidebar.css"> <!-- Sidebar CSS -->
    <link rel="stylesheet" href="public/css/modal.css"> <!-- Sidebar CSS -->

    <style>
    
    .calendar-section {
    padding: 20px;
    background-color: #1A2130;
    border-radius: 10px;
    margin: 20px auto;
    color: #fff;
}

.calendar {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: center;
}

.event-box {
    background-color: #2C3E50;
    width: 300px;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    text-align: center;
    position: relative;
    transition: transform 0.3s;
}

.event-box:hover {
    transform: translateY(-5px);
}

.event-box h4 {
    font-size: 20px;
    margin-bottom: 10px;
    color: #83B4FF;
}

.event-box p {
    font-size: 14px;
    margin: 10px 0;
}

.show-more-btn {
    background-color: #5A72A0;
    color: white;
    border: none;
    padding: 5px 10px;
    font-size: 12px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.show-more-btn:hover {
    background-color: #83B4FF;
}



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
        <!-- Card 1 -->
        <div class="activity-card">
            <img src="public/images/students-activity.jpg" alt="Art Workshop">
            <h3>Art Workshop</h3>
            <p>Nov 1st, 2:00 PM</p>
            <button class="learn-more-btn" onclick="showModal('artWorkshop')">Learn More</button>
        </div>
        <!-- Card 2 -->
        <div class="activity-card">
            <img src="public/images/robotics.jpg" alt="Robotics Meetup">
            <h3>Robotics Meetup</h3>
            <p>Nov 2nd, 3:00 PM</p>
            <button class="learn-more-btn" onclick="showModal('roboticsMeetup')">Learn More</button>
        </div>
        <!-- Card 3 -->
        <div class="activity-card">
            <img src="public/images/cooking.jpg" alt="Cooking Class">
            <h3>Cooking Class</h3>
            <p>Nov 3rd, 5:00 PM</p>
            <button class="learn-more-btn" onclick="showModal('cookingClass')">Learn More</button>
        </div>
    </div>
</section>



<section class="calendar-section">
    <h2>Upcoming Events</h2>
    <div class="calendar">
        <?php
        // Database connection
        require_once 'model/DB.php'; // Adjust path if needed
        $db = new DB();
        $conn = $db->getConnection();

        // Query to fetch 3 most upcoming events
        $query = "SELECT id, title, description, time, location 
                  FROM events 
                  WHERE time >= NOW() 
                  ORDER BY time ASC 
                  LIMIT 3";

        $result = $conn->query($query);

        // Check if there are any events
        if ($result && $result->num_rows > 0):
            while ($row = $result->fetch_assoc()):
        ?>
        <div class="event-box">
            <h4><?php echo htmlspecialchars($row['title']); ?></h4>
            <p><strong>Date:</strong> <?php echo date('D, d M Y', strtotime($row['time'])); ?></p>
            <p><strong>Time:</strong> <?php echo date('h:i A', strtotime($row['time'])); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
            <p class="description">
                <?php echo substr(htmlspecialchars($row['description']), 0, 100); ?>
                <?php if (strlen($row['description']) > 100): ?>
                    <span class="more-text" style="display: none;"><?php echo htmlspecialchars(substr($row['description'], 100)); ?></span>
                    <button class="show-more-btn" onclick="toggleDescription(this)">Show More</button>
                <?php endif; ?>
            </p>
        </div>
        <?php
            endwhile;
        else:
        ?>
        <p>No upcoming events at the moment.</p>
        <?php endif; ?>
    </div>
</section>




<section class="resources">
    <h2>Resources</h2>
    <div class="resource-items">
        <!-- Resource 1 -->
        <div class="resource-item">
            <h3>Student Handbook</h3>
            <a href="downloads/Student handbook.pdf" download="Student Handbook">Download PDF</a>
        </div>
        <!-- Resource 2 -->
        <div class="resource-item">
            <h3>Event Planning Guide</h3>
            <a href="downloads/event planning guide.pdf" download="Event Planning Guide">Download PDF</a>
        </div>
        <!-- Resource 3 -->
        <div class="resource-item">
            <h3>Volunteer Guide</h3>
            <a href="downloads/volunteer guide.pdf" download="Volunteer Guide">Download PDF</a>
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
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            if (sidebar) {
                sidebar.classList.toggle('sidebar-hidden');
                document.body.classList.toggle('sidebar-visible');
            }
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

<script>
function toggleDescription(button) {
    const moreText = button.previousElementSibling;
    const isExpanded = moreText.style.display === 'inline';
    if (isExpanded) {
        moreText.style.display = 'none';
        button.textContent = 'Show More';
    } else {
        moreText.style.display = 'inline';
        button.textContent = 'Show Less';
    }
}

function showModal(activity) {
        const modal = document.getElementById('modal');
        const modalBody = document.getElementById('modal-body');
        
        // Add descriptions for each activity
        const descriptions = {
            artWorkshop: `
                <h2>Art Workshop</h2>
                <p>Explore your creativity in this fun and interactive workshop. Learn painting, sketching, and other artistic techniques with professional guidance. Suitable for all skill levels.</p>
            `,
            roboticsMeetup: `
                <h2>Robotics Meetup</h2>
                <p>Join us for an exciting meetup on robotics. Engage in hands-on activities, learn about the latest technologies, and network with fellow robotics enthusiasts.</p>
            `,
            cookingClass: `
                <h2>Cooking Class</h2>
                <p>Discover the joy of cooking in this hands-on class. Learn to prepare delicious meals under the guidance of expert chefs. No prior experience required.</p>
            `
        };

        // Set the content dynamically
        modalBody.innerHTML = descriptions[activity];

        // Show the modal
        modal.style.display = 'block';
    }

    function closeModal() {
        const modal = document.getElementById('modal');
        modal.style.display = 'none';
    }

    // Close the modal when clicking outside the content
    window.onclick = function(event) {
        const modal = document.getElementById('modal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
</script>
<!-- Modal Section -->
<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <div id="modal-body">
            <!-- Dynamic content will be loaded here -->
        </div>
    </div>
</div>

</body>
</html>
