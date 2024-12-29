<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- Sidebar Toggle Button -->
<button class="sidebar-toggle-btn" onclick="toggleSidebar()">☰</button>

<div class="sidebar sidebar-hidden">
    <div class="sidebar-header">
        <div class="user-info">
            <p>Welcome, 
                <?php
                if (isset($_SESSION['FullName'])) {
                    echo htmlspecialchars($_SESSION['FullName']);
                } else {
                    echo "Guest";
                }
                ?>!
            </p>
        </div>
    </div>

    <div class="sidebar-content">
        <!-- Profile Section -->
        <div class="sidebar-item">
            <a href="<?php echo isset($_SESSION['FullName']) ? '/swee/view/profile.php' : '/swee/view/login.php'; ?>" 
               class="sidebar-btn">Profile</a>
        </div>

        <!-- Contact Tab -->
        <div class="sidebar-item">
            <a href="/swee/view/contact.php" class="sidebar-btn">Contact</a>
        </div>

        <!-- My Event Tab -->
        <div class="sidebar-item">
            <a href="/swee/view/Studentsevents.php" class="sidebar-btn">My Event</a>
        </div>

        <!-- Deactivate Account Button -->
        <?php if (isset($_SESSION['ID'])): ?>
            <div class="sidebar-item">
                <button class="deactivate-btn" onclick="confirmDeactivation()">Deactivate Account</button>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Function to toggle sidebar visibility
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('sidebar-hidden');
        document.body.classList.toggle('sidebar-visible');
    }

    // Confirm Deactivation
    function confirmDeactivation() {
        if (confirm("Are you sure you want to deactivate your account? This action cannot be undone.")) {
            window.location.href = "/swee/view/deactivate_account.php";
        }
    }
</script>

<style>
/* General Sidebar Styling */
body {
    font-family: Arial, sans-serif;
}

/* Sidebar Styles */
.sidebar {
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    background-color: #2c3e50;
    color: white;
    height: 100%;
    z-index: 2;
    box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
    transform: translateX(-100%);
    transition: transform 0.3s ease;
    display: flex;
    flex-direction: column;
}

.sidebar-hidden {
    transform: translateX(-100%);
}

.sidebar-visible {
    transform: translateX(0);
}

/* Sidebar Header */
.sidebar-header {
    background-color: #34495e;
    padding: 20px;
    text-align: center;
    border-bottom: 1px solid #1a242f;
}

.sidebar-header p {
    font-size: 18px;
    font-weight: bold;
    margin: 0;
}

/* Sidebar Content */
.sidebar-content {
    padding: 20px 10px;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.sidebar-item {
    text-align: center;
}

/* Sidebar Buttons */
.sidebar-btn {
    display: block;
    text-decoration: none;
    background-color: #34495e;
    color: white;
    padding: 12px 10px;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.sidebar-btn:hover {
    background-color: #1abc9c;
}

/* Deactivate Button */
.deactivate-btn {
    background-color: #e74c3c;
    color: white;
    padding: 12px 10px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.deactivate-btn:hover {
    background-color: #c0392b;
}

/* Sidebar Toggle Button */
.sidebar-toggle-btn {
    font-size: 30px;
    color: white;
    background: #34495e;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    position: fixed;
    top: 20px;
    left: 20px;
    cursor: pointer;
    z-index: 3;
    transition: background-color 0.3s ease;
}

.sidebar-toggle-btn:hover {
    background-color: #1abc9c;
}
</style>
