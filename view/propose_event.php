<?php
require_once '../control/ClubLeaderController.php';
require_once '../model/DB.php';

session_start();
include('header.php');
$db = new DB();
$conn = $db->getConnection();
$clubLeaderController = new ClubLeaderController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $events = $_POST['events'];
    $creator_id = $_SESSION['ID'];

    foreach ($events as $event) {
        $title = $event['title'];
        $time = $event['time'];
        $location = $event['location'];
        $member_limit = $event['member_limit'];

        $clubLeaderController->addProposedEvent($title, $time, $location, $member_limit, $creator_id);
    }

    header("Location: club_leader_dashboard.php?message=Proposals added successfully!");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propose Events</title>
    <link rel="stylesheet" href="../public/css/dashboard.css">
</head>
<body>
    <div class="container">
        <h1>Propose Events for Voting</h1>
        <form action="propose_event.php" method="POST">
            <div id="event-forms">
                <div class="event-form">
                    <label for="title">Title</label>
                    <input type="text" name="events[0][title]" required>

                    <label for="time">Time</label>
                    <input type="datetime-local" name="events[0][time]" required>

                    <label for="location">Location</label>
                    <input type="text" name="events[0][location]" required>

                    <label for="member_limit">Member Limit</label>
                    <input type="number" name="events[0][member_limit]" required>
                </div>
            </div>
            <button type="button" onclick="addEventForm()">Add Another Event</button>
            <button type="submit" class="btn">Submit Proposals</button>
        </form>
    </div>

    <script>
        let eventIndex = 1;

        function addEventForm() {
            const eventForms = document.getElementById('event-forms');
            const newForm = document.createElement('div');
            newForm.classList.add('event-form');
            newForm.innerHTML = `
                <label for="title">Title</label>
                <input type="text" name="events[${eventIndex}][title]" required>

                <label for="time">Time</label>
                <input type="datetime-local" name="events[${eventIndex}][time]" required>

                <label for="location">Location</label>
                <input type="text" name="events[${eventIndex}][location]" required>

                <label for="member_limit">Member Limit</label>
                <input type="number" name="events[${eventIndex}][member_limit]" required>
            `;
            eventForms.appendChild(newForm);
            eventIndex++;
        }
    </script>
</body>
</html>