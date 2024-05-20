<?php
include('admin/dbcon.php');
session_start();

// Assuming you are using POST method to submit the form
$username = $_POST['username'];
$password = $_POST['password'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$class_id = $_POST['class_id'];

// Use prepared statements to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM student WHERE username = ? AND firstname = ? AND lastname = ? AND class_id = ?");
$stmt->bind_param("sssi", $username, $firstname, $lastname, $class_id);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->num_rows;

if ($count > 0) {
    $row = $result->fetch_assoc();
    $id = $row['student_id'];

    // Update password and status
    $stmt = $conn->prepare("UPDATE student SET password = ?, status = 'Registered' WHERE student_id = ?");
    $stmt->bind_param("si", $password, $id);
    $stmt->execute();

    $_SESSION['id'] = $id;
    echo 'true';
} else {
    echo 'false';
}

$stmt->close();
$conn->close();
?>
