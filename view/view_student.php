<?php
include '..\model\DB.php';

$db = new DB();
$conn = $db->getConnection();

$success_message = ''; 
$student_data = null;  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];

    $sql = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $student_data = $result->fetch_assoc();
       
    } else {
        echo "No student found with this ID";
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <style>
        .success-message {
            background-color: #1a2130;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-weight: bold;
        }

        .error-message {
            background-color: #f44336;
            color: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 18px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    
    <?php if ($success_message): ?>
        <div class="success-message">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <form action="view_student.php" method="POST">
    </form>

    <?php if ($student_data): ?>
        <h2>Student Details</h2>
        <p><strong>Student Name:</strong> <?php echo htmlspecialchars($student_data['name']); ?></p>
        <p><strong>Student ID:</strong> <?php echo htmlspecialchars($student_data['student_id']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($student_data['email']); ?></p>
    <?php endif; ?>
</body>
</html>
