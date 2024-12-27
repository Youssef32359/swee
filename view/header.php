<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/css/index.css"> 
</head>
<header>
    <div class="logo">Student Activity Management</div>
    <nav>
        <a href="/index.php">Home</a>
        <a href="/view/manage_activities.php">Activities</a>
        <a href="/view/eventregistration.php">Events</a>
        <a href="/view/upcoming_events.php">Upcoming events</a>
        <a href="/view/contact.php">Contact</a>
        

        <?php if (!empty($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="/view/dashboard.php">Admin Dashboard</a>
        <?php endif; ?>
    </nav>

    <div class="user-actions">
        <?php if(!empty($_SESSION['ID'])): ?>
            
            <div class="profile">
                <span>User</span>
                <img src="public\images\download.jpg" alt="Profile Picture" width="40" height="40">
            </div>
            <a href="/view/signout.php" class="button">Logout</a>
        <?php else: ?>
            
            <a href="/view/login.php" class="button">Login</a>
            <a href="/view/signup.php" class="button">Sign Up</a>
        <?php endif; ?>
    </div>
</header>
</html>


