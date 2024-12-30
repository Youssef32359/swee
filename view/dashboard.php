<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../control/AdminController.php';

$adminController = new AdminController();
$users = $adminController->getAllUsers();
$events = $adminController->getAllEvents();

$success_message = '';
$error_message = '';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $mobile = $_POST['mobile'];
        $role = $_POST['role'];
        $message = $adminController->createUser($fullname, $email, $password, $mobile, $role);
        $success_message = $message;
    }

    if (isset($_POST['delete_user_id'])) {
        $userId = intval($_POST['delete_user_id']);
        $message = $adminController->deleteUser($userId);
    
        // Reload the page to show updated user list
        echo "<script>alert('$message'); window.location.href='dashboard.php#viewUsers';</script>";
        exit;
    }
    

    if (isset($_POST['create_event'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $time = $_POST['time'];
        $location = $_POST['location'];
        $memberLimit = intval($_POST['member_limit']);
        $createdBy = intval($_POST['created_by']);
        $message = $adminController->createEvent($title, $description, $time, $location, $memberLimit, $createdBy);
        $success_message = $message;
    }

    if (isset($_POST['delete_event_id'])) {
        $eventId = intval($_POST['delete_event_id']);
        $message = $adminController->deleteEvent($eventId);
        $success_message = $message;
    }

    if (isset($_POST['generate_reports'])) {
        // Example: Generate a report and store it
        $reportData = $adminController->generateReport();
        $success_message = "Report generated successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #1a2130;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 40px;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 300px;
            text-align: center;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
        }

        .card h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #1a2130;
        }

        section {
            display: none;
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            width: 80%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        section.active {
            display: block;
        }

        form input, form select, form textarea, form button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form button {
            background-color: #1a2130;
            color: white;
            cursor: pointer;
        }

        form button:hover {
            background-color: #5a72a0;
        }

        .success-message, .error-message {
            padding: 15px;
            margin: 20px auto;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
            max-width: 500px;
        }

        .success-message {
            background-color: #4CAF50;
            color: white;
        }

        .error-message {
            background-color: #f44336;
            color: white;
        }
    </style>
    <script>
        function showSection(sectionId) {
            document.querySelectorAll('section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
        }
    </script>
</head>
<body>
<header>Admin Dashboard</header>

<?php if (!empty($success_message)): ?>
    <div class="success-message"><?php echo $success_message; ?></div>
<?php elseif (!empty($error_message)): ?>
    <div class="error-message"><?php echo $error_message; ?></div>
<?php endif; ?>

<div class="container">
    <div class="card" onclick="showSection('addUser')">
        <h2>Add User</h2>
    </div>
    <div class="card" onclick="showSection('viewUsers')">
        <h2>View Users</h2>
    </div>
    <div class="card" onclick="showSection('addEvent')">
        <h2>Add Event</h2>
    </div>
    <div class="card" onclick="showSection('viewEvents')">
        <h2>View Events</h2>
    </div>
    <div class="card" onclick="showSection('generateReports')">
        <h2>Generate Reports</h2>
    </div>
</div>

<section id="addUser">
    <h2>Add User</h2>
    <form method="POST">
        <input type="hidden" name="add_user" value="1">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="mobile" placeholder="Mobile Number" required>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
            <option value="club_leader">Club Leader</option>
        </select>
        <button type="submit">Add User</button>
    </form>
</section>

<section id="viewUsers">
    <h2>View Users</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>
                <?php echo $user['fullname']; ?> (<?php echo $user['role']; ?>)
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_user_id" value="<?php echo $user['id']; ?>">
                    <button type="submit">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<section id="addEvent">
    <h2>Add Event</h2>
    <form method="POST">
        <input type="hidden" name="create_event" value="1">
        <input type="text" name="title" placeholder="Event Title" required>
        <textarea name="description" placeholder="Event Description" required></textarea>
        <input type="datetime-local" name="time" required>
        <input type="text" name="location" placeholder="Event Location" required>
        <input type="number" name="member_limit" placeholder="Member Limit" required>
        <input type="number" name="created_by" placeholder="Created By (Admin ID)" required>
        <button type="submit">Add Event</button>
    </form>
</section>

<section id="viewEvents">
    <h2>View Events</h2>
    <ul>
        <?php foreach ($events as $event): ?>
            <li>
                <?php echo $event['title']; ?> on <?php echo $event['time']; ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="delete_event_id" value="<?php echo $event['id']; ?>">
                    <button type="submit">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<section id="generateReports">
    <h2>Generate Reports</h2>
    <form method="POST">
        <input type="hidden" name="generate_reports" value="1">
        <button type="submit">Generate Report</button>
    </form>
</section>

</body>
</html>
