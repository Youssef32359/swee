<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include('sidebar.php');

require_once '../control/AdminController.php';

$adminController = new AdminController();
$users = $adminController->getAllUsers();
$events = $adminController->getAllEvents();

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $mobile = $_POST['mobile'];
        $role = $_POST['role'];
        $success_message = $adminController->createUser($fullname, $email, $password, $mobile, $role);
    }

    if (isset($_POST['delete_user_id'])) {
        $userId = intval($_POST['delete_user_id']);
        $success_message = $adminController->deleteUser($userId);
    }

    if (isset($_POST['create_event'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $time = $_POST['time'];
        $location = $_POST['location'];
        $member_limit = intval($_POST['member_limit']);
        $created_by = intval($_POST['created_by']);
        $success_message = $adminController->createEvent($title, $description, $time, $location, $member_limit, $created_by);
    }

    if (isset($_POST['delete_event_id'])) {
        $eventId = intval($_POST['delete_event_id']);
        $success_message = $adminController->deleteEvent($eventId);
    }

    if (isset($_POST['generate_report'])) {
        $reportType = $_POST['report_type'];
        $adminController->generateReport($reportType);
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
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    color: #333;
    background-image: url('../public/images/universal.jpg'); /* Adjust the path as necessary */
    background-repeat: no-repeat;
    background-position: center center;
    background-attachment: fixed;
    background-size: cover;
}
        header { background-color: #333; color: white; padding: 20px; text-align: center; font-size: 24px; }
        .container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; margin-top: 20px; }
        .card { padding: 20px; background: white; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); width: 250px; text-align: center; cursor: pointer; }
        .card:hover { background-color: #f1f1f1; }
        section { display: none; padding: 20px; margin: 20px auto; width: 80%; background: white; border-radius: 8px; }
        section.active { display: block; }
        form { margin: 10px 0; }
        form input, form select, form button { width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px; }
        form button { background-color: #333; color: white; border: none; }
        form button:hover { background-color: #555; }
    </style>
    <script>
        function showSection(id) {
            document.querySelectorAll('section').forEach(sec => sec.classList.remove('active'));
            document.getElementById(id).classList.add('active');
        }
    </script>
</head>
<body>
    <header>Admin Dashboard</header>

    <div class="container">
        <div class="card" onclick="showSection('addUser')">Add User</div>
        <div class="card" onclick="showSection('viewUsers')">View Users</div>
        <div class="card" onclick="showSection('addEvent')">Add Event</div>
        <div class="card" onclick="showSection('viewEvents')">View Events</div>
        <div class="card" onclick="showSection('generateReports')">Generate Reports</div>
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
            <input type="hidden" name="generate_report" value="1">
            <select name="report_type" required>
                <option value="users">Users Report</option>
                <option value="events">Events Report</option>
            </select>
            <button type="submit">Generate Report</button>
        </form>
    </section>
</body>
</html>
