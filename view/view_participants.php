<?php
require_once '../control/ClubLeaderController.php';
require_once '../model/DB.php';
include('header.php');

session_start();
$db = new DB();
$conn = $db->getConnection();
$clubLeaderController = new ClubLeaderController($conn);

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Get participants
    $participants = $clubLeaderController->getParticipants($event_id);
} else {
    header("Location: club_leader_dashboard.php?message=" . urlencode("Event ID not provided."));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Participants</title>
    <link rel="stylesheet" href="../public/css/particpants.css">
</head>
<body>
<div class="container">
    <h1>Participants for Event ID: <?php echo htmlspecialchars($event_id); ?></h1>
    <a href="club_leader_dashboard.php" class="btn-secondary">Back to Dashboard</a>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($participant = $participants->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($participant['id']); ?></td>
                        <td><?php echo htmlspecialchars($participant['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($participant['email']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
