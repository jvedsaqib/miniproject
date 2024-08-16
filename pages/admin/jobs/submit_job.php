<?php
include_once('../admin_session.php');
include_once("../../../php/connection.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reference_number = $_POST['reference_number'];
    $post_date = $_POST['post_date'];
    $batch_year = $_POST['batch_year'];
    $recruiting_company = $_POST['recruiting_company'];
    $streams = isset($_POST['streams']) ? implode(', ', $_POST['streams']) : null;
    $backlogs = $_POST['backlogs'];
    $minimum_cgpa = $_POST['minimum_cgpa'];
    $eligibility_description = $_POST['eligibility_description'];
    $selection_mode = $_POST['selection_mode'];
    $selection_mode_description = $_POST['selection_mode_description'];
    $selection_process = $_POST['selection_process'];
    $selection_date = $_POST['selection_date'];
    $designation = $_POST['designation'];
    $remuneration = $_POST['remuneration'];
    $location = $_POST['location'];
    $class_x_percentage = $_POST['class_x_percentage'];
    $class_xii_percentage = $_POST['class_xii_percentage'];
    $graduation_cgpa = $_POST['graduation_cgpa'];
    $postgraduation_cgpa = $_POST['postgraduation_cgpa'];

    $sql = "INSERT INTO job_posting 
    (reference_number, post_date, batch_year, recruiting_company, streams, 
    backlogs, minimum_cgpa, eligibility_description, selection_mode, 
    selection_mode_description, selection_process, selection_date, 
    designation, remuneration, location, class_x_percentage, class_xii_percentage, graduation_cgpa, postgraduation_cgpa) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind the parameters (make sure the number and type match)
    $stmt->bind_param("ssissidssssssssdddd", $reference_number, $post_date, $batch_year, $recruiting_company, $streams, 
    $backlogs, $minimum_cgpa, $eligibility_description, $selection_mode, 
    $selection_mode_description, $selection_process, $selection_date, 
    $designation, $remuneration, $location, $class_x_percentage, $class_xii_percentage, $graduation_cgpa, $postgraduation_cgpa);


    if ($stmt->execute()) {
        echo "Job posting successfully added!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: ../admin_home.php");
}
?>

