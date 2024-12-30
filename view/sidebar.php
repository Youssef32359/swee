<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/swee/public/css/sidebar.css"> 
</head>
<body>
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
                <?php if (isset($_SESSION['role'])): ?>
                    <p style="font-size: 14px; color: #ecf0f1;">
                        Role: 
                        <?php 
                        // Display "Student" instead of "User"
                        echo htmlspecialchars($_SESSION['role'] === 'user' ? 'Student' : ucfirst($_SESSION['role'])); 
                        ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="sidebar-content">
            <!-- Profile Section -->
            <div class="sidebar-item">
                <a href="<?php echo isset($_SESSION['FullName']) ? '/swee/view/profile.php' : '/swee/view/login.php'; ?>" 
                   class="sidebar-btn">Profile</a>
            </div>

            <!-- Role-Specific Sidebar Items -->
            <?php if (isset($_SESSION['role'])): ?>
                <?php if ($_SESSION['role'] === 'club_leader'): ?>
                    <!-- Club Leader Specific Options -->
                    <div class="sidebar-item">
                        <a href="/swee/view/club_leader_dashboard.php" class="sidebar-btn">View Events</a>
                    </div>
                    <div class="sidebar-item">
                        <a href="/swee/view/propose_event.php" class="sidebar-btn">Add Events for Voting</a>
                    </div>
                <?php elseif ($_SESSION['role'] === 'admin'): ?>
                    <!-- Admin Specific Options -->
                    <div class="sidebar-item">
                        <a href="/swee/view/dashboard.php" class="sidebar-btn">Admin Dashboard</a>
                    </div>
                <?php elseif ($_SESSION['role'] === 'user'): ?>
                    <!-- Student Specific Options -->
                    <div class="sidebar-item">
                        <a href="/swee/view/Studentsevents.php" class="sidebar-btn">My Events</a>
                    </div>
                    <div class="sidebar-item">
                        <a href="/swee/view/eventvoting.php" class="sidebar-btn">Vote for Events</a>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <!-- Guest Options -->
                <div class="sidebar-item">
                    <a href="/swee/view/login.php" class="sidebar-btn">Login</a>
                </div>
            <?php endif; ?>

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
        const body = document.body;
        sidebar.classList.toggle('sidebar-hidden');
        body.classList.toggle('sidebar-visible');
    }
    </script>
</body>
</html>
