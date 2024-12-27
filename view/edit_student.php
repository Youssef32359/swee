<?php
include '..\model\DB.php';

$db = new DB();
$conn = $db->getConnection();

$student_id = null;
$success_message = ''; 
if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
    
    $student_id = htmlspecialchars($_GET['student_id'], ENT_QUOTES, 'UTF-8');
} elseif (isset($_POST['student_id']) && !empty($_POST['student_id'])) {
    $student_id = htmlspecialchars($_POST['student_id'], ENT_QUOTES, 'UTF-8');
} else {
    echo "Student ID not provided or invalid.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && $student_id) {
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
    } else {
        echo "Student not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password']; 

    $stmt = $conn->prepare("UPDATE students SET name = ?, email = ?, password = ? WHERE student_id = ?");
    $stmt->bind_param("ssss", $name, $email, $password, $student_id);

    if ($stmt->execute()) {
       
        $success_message = "Student updated successfully!";
    } else {
        echo "Error updating student: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
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

    <form action="edit_student.php" method="POST">
       
    </form>
</body>
</html>
