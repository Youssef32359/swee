<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #d9d9d9;
            color: #333;
            text-align: center;
        }

        header {
            background-color: #1a2130;
            color: #ffffff;
            padding: 20px;
        }

        h1 {
            margin: 0;
            font-size: 36px;
            text-align: center;
        }

        nav {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        nav a {
            background-color: #5a72a0;
            padding: 15px 30px;
            border-radius: 8px;
            color: #ffffff;
            text-decoration: none;
            font-size: 18px;
            transition: background-color 0.3s, transform 0.2s;
        }

        nav a:hover {
            background-color: #83b4ff;
            transform: scale(1.05);
        }

        section {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 10px;
            margin: 30px auto;
            max-width: 800px;
            display: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        button {
            background-color: #5a72a0;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: #ffffff;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        button:hover {
            background-color: #83b4ff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #1a2130;
            color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }

        th,
        td {
            padding: 15px;
            border: 1px solid #3e4a5b;
            text-align: center;
        }

        th {
            background-color: #3e4a5b;
        }

        input:focus, textarea:focus, button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.5); 
        }
    </style>
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
        <button onclick="showSection('editStudent')">Edit Student</button>
        <button onclick="showSection('deleteStudent')">Delete Student</button>
    </section>

    <section id="editStudent">
        <h2>Edit Student</h2>
        <form action="edit_student.php" method="post">
            <input type="text" name="student_id" placeholder="Student ID" required />
            <input type="text" name="name" placeholder="New Name" />
            <input type="email" name="email" placeholder="New Email" />
            <input type="password" name="password" placeholder="New Password" />
            <button type="submit">Update Student</button>
        </form>
    </section>

    <section id="deleteStudent">
        <h2>Delete Student</h2>
        <form action="delete_student.php" method="post">
            <input type="text" name="student_id" placeholder="Student ID" required />
            <button type="submit">Delete Student</button>
        </form>
    </section>

    <section id="eventManagement">
        <h2>Event Management</h2>
        <button onclick="showSection('addEvent')">Add Event</button>
        <button onclick="showSection('viewEvents')">View Events</button>
        
    </section>

    <section id="addEvent">
        <h2>Add Event</h2>
        <form action="add_event.php" method="post">
            <label for="eventName">Event Name:</label>
            <input type="text" id="eventName" name="event_name" required />
            <label for="eventDate">Event Date:</label>
            <input type="date" id="eventDate" name="event_date" required />
            <button type="submit">Add Event</button>
        </form>
    </section>

    <section id="viewEvents">
        <h2>Event Participation & Analytics</h2>
        <table id="eventsTable">
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php include '..\view\view_event.php'; ?>
            </tbody>
        </table>
    </section>

    <script>
        function loadEvents() {
            
            fetch('view_events.php')
                .then(response => response.text())
                .then(data => {
                    document.querySelector('#eventsTable tbody').innerHTML = data;
                })
                .catch(error => console.error('Error loading events:', error));
        }

        
        document.querySelector("a[href='#viewEvents']").addEventListener('click', () => {
            showSection('viewEvents'); 
            loadEvents(); 
        }); 

       
        function showSection(sectionId) {
            document.querySelectorAll('section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>

<section id="generateReports">
    <h2>Generate Reports</h2>
    <form action="generate_report.php" method="get">
        <button type="submit">Go to Generate Report Page</button>
    </form>
</section>


    <footer>
        <p>&copy; 2024 Admin Dashboard</p>
    </footer>
</body>
</html>
