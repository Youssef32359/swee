<?php
include '../model/DB.php'; 

$db = new DB();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];

    $sql = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "Student Name: " . $row['name'] . "<br>";
        echo "Student ID: " . $row['student_id'] . "<br>";
        echo "Email: " . $row['email'] . "<br>";
    } else {
        echo "No student found with this ID";
    }
    $conn->close();
}
?>
