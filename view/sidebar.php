<?php
// Start the session in the sidebar to make sure it happens only once.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Sidebar Toggle Button -->
<button class="sidebar-toggle-btn" onclick="toggleSidebar()">☰</button>

<div class="sidebar sidebar-hidden">
    <div class="sidebar-item">
        <div class="user-info">
            <p>Welcome, 
                <?php
                // Display the logged-in user's name from the session
                if (isset($_SESSION['FullName'])) {
                    echo htmlspecialchars($_SESSION['FullName']);
                } else {
                    echo "Guest";
                }
                ?>!
            </p>
        </div>
        
        <!-- Profile Section - Link to profile.php -->
        <a href="<?php echo isset($_SESSION['FullName']) ? '/swee/view/profile.php' : '/swee/view/login.php'; ?>" 
           class="dropdown-btn">&#9660; Profile</a>
        
        <div class="dropdown-content">
            <?php if (isset($_SESSION['FullName'])): ?>
                <a href="profile.php">View Profile</a>
            <?php else: ?>
                <a href="login.php">Log In</a>
                <a href="signup.php">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Contact Tab -->
    <div class="sidebar-item">
        <a href="/swee/view/contact.php" class="dropdown-btn">&#9660; Contact</a>
    </div>

    <!-- My Event Tab -->
    <div class="sidebar-item">
        <a href="/swee/view/Studentsevents.php" class="dropdown-btn">&#9660; My Event</a>
    </div>
</div>

<script>
    // Function to toggle sidebar visibility
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const body = document.body;

        // Toggle the sidebar visibility
        sidebar.style.transform = (sidebar.style.transform === 'translateX(0px)') 
            ? 'translateX(-100%)'  // If sidebar is shown, hide it
            : 'translateX(0)';      // If sidebar is hidden, show it
        
        // Toggle the class on body to shift content accordingly
        body.classList.toggle('sidebar-visible');
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

<style>
/* Sidebar Style */
.sidebar {
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #333;
    color: white;
    height: 100%;
    padding-top: 20px;
    z-index: 2;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
    transition: transform 0.3s ease; /* Smooth transition */
    transform: translateX(-100%); /* Initially off-screen */
    padding-bottom: 20px;
}

/* Sidebar Toggle Button */
.sidebar-toggle-btn {
    font-size: 30px;
    color: white;
    background: none;
    border: none;
    position: fixed;
    top: 10px;
    left: 10px;
    cursor: pointer;
    z-index: 3;
}

/* Sidebar Items */
.sidebar-item {
    margin-bottom: 15px;
    text-align: center;
}

/* Dropdown Menu Buttons */
.sidebar-item .dropdown-btn {
    cursor: pointer;
    padding: 10px;
    display: block;
    background-color: #444;
    color: white;
    text-align: left;
    font-size: 16px;
    border: none;
    width: 100%;
}

/* Dropdown Content */
.sidebar-item .dropdown-content {
    display: none;
    background-color: #555;
    padding-left: 20px;
}

.sidebar-item .dropdown-content a {
    padding: 10px;
    color: white;
    text-decoration: none;
    display: block;
}

/* Hover Effects */
.sidebar-item .dropdown-content a:hover {
    background-color: #666;
}

.sidebar-item .active .dropdown-content {
    display: block;
}
</style>
