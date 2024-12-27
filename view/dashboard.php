<?php
session_start();

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../public/css/admin.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
    </header>

    <nav>
        <a href="#addStudent" onclick="showSection('addStudent')">Add Student</a>
        <a href="#viewStudent" onclick="showSection('viewStudent')">View Student</a>
        <a href="#eventManagement" onclick="showSection('eventManagement')">Event Management</a>
        <a href="#generateReports" onclick="showSection('generateReports')">Generate Reports</a>
        <a href="signout.php">Logout</a>
    </nav>

    <section id="addStudent">
        <h2>Add Student</h2>
        <form action="add_student.php" method="post"> 
            <input type="text" name="name" placeholder="Name" required />
            <input type="text" name="student_id" placeholder="Student ID" required />
            <input type="email" name="email" placeholder="Email" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit">Add Student</button>
        </form>
    </section>

    <section id="viewStudent">
        <h2>View Student</h2>
        <form action="view_student.php" method="post"> 
            <input type="text" name="student_id" placeholder="Enter Student ID" required />
            <button type="submit">View Student Details</button>
        </form>
    </section>

    <section id="studentDetails">
        <h2></h2>
        <p id="detailsOutput"><span id="studentIdDisplay"></span></p>
        <button onclick="showSection('viewStudent')">Back</button>
    </section>

    <section id="eventManagement">
        <h2>Event Management</h2>
        <p></p>
        <button onclick="showSection('addEvent')">Add Event</button>
        <button onclick="showSection('viewEvents')">View Events</button>
        <button onclick="showSection('manageEvents')">Manage Events</button>
    </section>

    <section id="addEvent">
        <h2>Add Event</h2>
        <form action="add_event.php" method="post"> 
            <label for="eventName">Event Name:</label>
            <input type="text" id="eventName" name="event_name" placeholder="" required />
            <br />
            <label for="eventDate">Event Date:</label>
            <input type="date" id="eventDate" name="event_date" required />
            <br />
            <button type="submit">Add Event</button>
        </form>
    </section>

    <section id="viewEvents">
        <div class="analytics">
            <h2>Event Participation & Analytics</h2>
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Total Participants</th>
                        <th>Spots Available</th>
                        <th>Engagement Level (%)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sports Day</td>
                        <td>October 25, 2024</td>
                        <td>100</td>
                        <td>10</td>
                        <td>90.9%</td>
                    </tr>
                    <tr>
                        <td>Tech Conference</td>
                        <td>November 10, 2024</td>
                        <td>75</td>
                        <td>5</td>
                        <td>93.8%</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <section id="manageEvents">
        <h2>Manage Events</h2>
        <div class="event-list">
            <div class="event">
                <h3>Sports Day</h3>
                <p>Date: October 25, 2024</p>
                <p>Participants: 100</p>
                <button type="submit">Delete</button>
                <button type="submit">Edit</button>
            </div>

            <div class="event">
                <h3>Tech Conference</h3>
                <p>Date: November 10, 2024</p>
                <p>Participants: 75</p>
                <button type="submit">Delete</button>
                <button type="submit">Edit</button>
            </div>
        </div>
    </section>

    <section id="generateReports">
        <h2>Generate Reports</h2>
        <p></p>
        <button onclick="showSection('generateAttendanceReport')">Generate Attendance Report</button>
        <button onclick="showSection('generateParticipationReport')">Generate Event Participation Report</button>
    </section>

    <section id="generateAttendanceReport">
        <h2>Generate Attendance Report</h2>
        <p></p>
        <textarea placeholder="report here..."></textarea>
        <button>Save Report</button>
    </section>

    <section id="generateParticipationReport">
        <h2>Generate Event Participation Report</h2>
        <p>Write your event participation report below:</p>
        <textarea placeholder="report here..."></textarea>
        <button>Save Report</button>
    </section>

    <section id="logout">
        <h2></h2>
    </section>

    <footer>
        <p>Admin Dashboard © 2024</p>
    </footer>

    <script>
        function showSection(sectionId) {
            const sections = document.querySelectorAll("section");
            sections.forEach((section) => {
                section.style.display = "none";
            });

            const selectedSection = document.getElementById(sectionId);
            selectedSection.style.display = "block";

            if (sectionId === "studentDetails") {
                const studentId = document.getElementById("studentIdView").value;
                document.getElementById("studentIdDisplay").textContent =
                    studentId || "N/A";
            }
        }

        showSection("addStudent");
    </script>
</body>
</html>
