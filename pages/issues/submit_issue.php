<?php 
include_once("../../php/connection.php"); 
session_start();

if (!isset($_SESSION['login_user'])) {
    header("location: ../student_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_roll = $_POST['student_roll'];
    $issues = isset($_POST['issues']) ? implode(", ", $_POST['issues']) : '';
    $description = $conn->real_escape_string($_POST['description']);

    $query = "INSERT INTO issues (StudentRoll, Issues, Description) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $student_roll, $issues, $description);

    if ($stmt->execute()) {
        echo "Issue submitted successfully.";
    } else {
        echo "Error submitting issue.";
    }
}
?>