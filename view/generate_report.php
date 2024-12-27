<?php

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "student_activity_management";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a unique random ID between 1 and 99
function generateUniqueID($conn) {
    do {
        $randomID = rand(1, 99);
        $query = "SELECT ID FROM reports WHERE ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $randomID);
        $stmt->execute();
        $result = $stmt->get_result();
    } while ($result->num_rows > 0); 
    return $randomID;
}

$successMessage = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    if (!isset($_POST['student_id']) || empty($_POST['student_id'])) {
        die("Student ID is required.");
    }

    $input_student_id = $_POST['student_id'];

    
    $sql = "SELECT id FROM students WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $input_student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        die("Invalid student ID. No such student exists.");
    }

    $student = $result->fetch_assoc();
    $student_id = $student['id'];

    
    $users_id = $_POST['users_id']; 
    $event_id = $_POST['event_id']; 
    $participation_report = $_POST['participation_report'];
    $attendance_report = $_POST['attendance_report'];

   
    $report_id = generateUniqueID($conn);

    
    $insert_sql = "
        INSERT INTO reports (ID, users_id, event_id, Participation_report, Attendance_report, student_id)
        VALUES (?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param(
        "iiissi",
        $report_id,
        $users_id,
        $event_id,
        $participation_report,
        $attendance_report,
        $student_id
    );

    if ($insert_stmt->execute()) {
        $successMessage = "Report successfully saved";
    } else {
        echo "<p class='error'>Error generating report: " . $conn->error . "</p>";
    }

    
    $insert_stmt->close();
}


$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>Generate Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }
        .container {
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            color: #555;
        }
        input, textarea, button {
            width: 100%;
            margin-top: 8px;
            margin-bottom: 16px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        textarea {
            resize: none;
        }
        button {
            background-color: #003366;
            color: #fff;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #002244;
        }
        .success {
            color: #003366;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .error {
            color: #dc3545;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php if (!empty($successMessage)): ?>
        <p class="success"><?php echo $successMessage; ?></p>
    <?php endif; ?>
    <div class="container">
        <h1>Generate a Report</h1>
        <form method="POST" action="">
            <label for="student_id">Student ID:</label>
            <input type="text" id="student_id" name="student_id" required>

            <label for="users_id">Author ID:</label>
            <input type="number" id="users_id" name="users_id" required>

            <label for="event_id">Event ID:</label>
            <input type="number" id="event_id" name="event_id" required>

            <label for="participation_report">Participation Report:</label>
            <textarea id="participation_report" name="participation_report" rows="4" required></textarea>

            <label for="attendance_report">Attendance Report:</label>
            <textarea id="attendance_report" name="attendance_report" rows="4" required></textarea>

            <button type="submit">Generate Report</button>
        </form>
    </div>
</body>
</html>
