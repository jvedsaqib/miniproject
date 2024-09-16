<?php
include_once('../../../php/connection.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$job = [];
$errors = [];

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];

    $sql = "SELECT * FROM job_posting WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Preparation failed: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("i", $job_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $job = $result->fetch_assoc();
    } else {
        echo "Job not found.";
        exit();
    }
} else {
    echo "No job ID provided.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {

    $reference_number = trim($_POST['reference_number']);
    $post_date = trim($_POST['post_date']);
    $batch_year = intval($_POST['batch_year']);
    $recruiting_company = trim($_POST['recruiting_company']);
    $streams = isset($_POST['streams']) ? implode(', ', $_POST['streams']) : '';
    $backlogs = intval($_POST['backlogs']);
    $minimum_cgpa = floatval($_POST['minimum_cgpa']);
    $eligibility_description = trim($_POST['eligibility_description']);
    $selection_mode = trim($_POST['selection_mode']);
    $selection_mode_description = trim($_POST['selection_mode_description']);
    $selection_process = trim($_POST['selection_process']);
    $selection_date = trim($_POST['selection_date']);
    $designation = trim($_POST['designation']);
    $remuneration = trim($_POST['remuneration']);
    $location = trim($_POST['location']);
    $class_x_percentage = floatval($_POST['class_x_percentage']);
    $class_xii_percentage = floatval($_POST['class_xii_percentage']);
    $graduation_cgpa = floatval($_POST['graduation_cgpa']);
    $postgraduation_cgpa = floatval($_POST['postgraduation_cgpa']);


    $update_sql = "UPDATE job_posting SET 
        reference_number = ?, 
        post_date = ?, 
        batch_year = ?, 
        recruiting_company = ?, 
        streams = ?, 
        backlogs = ?, 
        minimum_cgpa = ?, 
        eligibility_description = ?, 
        selection_mode = ?, 
        selection_mode_description = ?, 
        selection_process = ?, 
        selection_date = ?, 
        designation = ?, 
        remuneration = ?, 
        location = ?, 
        class_x_percentage = ?, 
        class_xii_percentage = ?, 
        graduation_cgpa = ?, 
        postgraduation_cgpa = ?
        WHERE id = ?";

    $update_stmt = $conn->prepare($update_sql);
    if (!$update_stmt) {
        die("Preparation failed: (" . $conn->errno . ") " . $conn->error);
    }


    $update_stmt->bind_param(
        "ssissidssssssssddddi",
        $reference_number,
        $post_date,
        $batch_year,
        $recruiting_company,
        $streams,
        $backlogs,
        $minimum_cgpa,
        $eligibility_description,
        $selection_mode,
        $selection_mode_description,
        $selection_process,
        $selection_date,
        $designation,
        $remuneration,
        $location,
        $class_x_percentage,
        $class_xii_percentage,
        $graduation_cgpa,
        $postgraduation_cgpa,
        $job_id
    );

    if ($update_stmt->execute()) {
        echo "<script>alert('Job updated successfully!'); window.location.href='list_job.php';</script>";
        exit();
    } else {
        echo "Error updating job: " . $update_stmt->error;
    }

    $update_stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove'])) {
 
    $delete_sql = "DELETE FROM job_posting WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    if (!$delete_stmt) {
        die("Preparation failed: (" . $conn->errno . ") " . $conn->error);
    }
    $delete_stmt->bind_param("i", $job_id);

    if ($delete_stmt->execute()) {
        echo "<script>alert('Job removed successfully!'); window.location.href='list_job.php';</script>";
        exit();
    } else {
        echo "Error removing job: " . $delete_stmt->error;
    }

    $delete_stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Job</title>
    <link rel="stylesheet" href="../../../css/nav.css">
    <link rel="stylesheet" href="edit_job.css">
</head>
<body>
    <div class="topnav" id="home-topnav">
        <nav>
            <a href="../admin_logout.php" class="split">Sign Out</a>
            <a href="../admin_home.php">Home</a>
            <a href="post_job.php">Job Posting</a>
            <a href="list_job.php">List Jobs</a>
        </nav>
    </div>

    <div class="container">
        <form method="post" action="" onsubmit="return confirmUpdate();">
            <h2>Edit Job Posting Details</h2>

            <label for="reference_number">Reference Number:</label>
            <input type="text" id="reference_number" name="reference_number" value="<?php echo htmlspecialchars($job['reference_number']); ?>" required>

            <label for="post_date">Date:</label>
            <input type="date" id="post_date" name="post_date" value="<?php echo htmlspecialchars($job['post_date']); ?>" required>

            <label for="batch_year">Batch Year:</label>
            <input type="number" id="batch_year" name="batch_year" min="2000" max="2099" value="<?php echo htmlspecialchars($job['batch_year']); ?>" required>

            <label for="recruiting_company">Recruiting Company:</label>
            <input type="text" id="recruiting_company" name="recruiting_company" value="<?php echo htmlspecialchars($job['recruiting_company']); ?>" required>

            <fieldset>
                <legend>Streams Considered:</legend>
                <?php
                $all_streams = ["Btech", "AEIE", "CSBS", "CSE", "DS", "AIML", "CE", "IT", "ECE", "EE", "MCA", "MTECH"];
                $selected_streams = explode(', ', $job['streams']);
                ?>
                <label><input type="checkbox" name="streams[]" value="Btech" <?php if (in_array("Btech", $selected_streams)) echo "checked"; ?>> Btech</label><br>
                <div class="sub-checkbox">
                    <label><input type="checkbox" name="streams[]" value="AEIE" <?php if (in_array("AEIE", $selected_streams)) echo "checked"; ?>> AEIE</label>
                    <label><input type="checkbox" name="streams[]" value="CSBS" <?php if (in_array("CSBS", $selected_streams)) echo "checked"; ?>> CSBS</label>
                    <label><input type="checkbox" name="streams[]" value="CSE" <?php if (in_array("CSE", $selected_streams)) echo "checked"; ?>> CSE</label>
                    <label><input type="checkbox" name="streams[]" value="DS" <?php if (in_array("DS", $selected_streams)) echo "checked"; ?>> DS</label>
                    <label><input type="checkbox" name="streams[]" value="AIML" <?php if (in_array("AIML", $selected_streams)) echo "checked"; ?>> AIML</label>
                    <label><input type="checkbox" name="streams[]" value="CE" <?php if (in_array("CE", $selected_streams)) echo "checked"; ?>> CE</label>
                    <label><input type="checkbox" name="streams[]" value="IT" <?php if (in_array("IT", $selected_streams)) echo "checked"; ?>> IT</label>
                    <label><input type="checkbox" name="streams[]" value="ECE" <?php if (in_array("ECE", $selected_streams)) echo "checked"; ?>> ECE</label>
                    <label><input type="checkbox" name="streams[]" value="EE" <?php if (in_array("EE", $selected_streams)) echo "checked"; ?>> EE</label>
                </div>
                <label><input type="checkbox" name="streams[]" value="MCA" <?php if (in_array("MCA", $selected_streams)) echo "checked"; ?>> MCA</label><br>
                <label><input type="checkbox" name="streams[]" value="MTECH" <?php if (in_array("MTECH", $selected_streams)) echo "checked"; ?>> MTECH</label>
            </fieldset>

            <fieldset>
                <legend>Eligibility Criteria:</legend>
                <label for="backlogs">Number of Backlogs:</label>
                <input type="number" id="backlogs" name="backlogs" min="0" value="<?php echo htmlspecialchars($job['backlogs']); ?>" required>

                <label for="minimum_cgpa">Minimum CGPA:</label>
                <input type="number" id="minimum_cgpa" name="minimum_cgpa" step="0.01" value="<?php echo htmlspecialchars($job['minimum_cgpa']); ?>" required>

                <label for="eligibility_description">Description:</label>
                <textarea id="eligibility_description" name="eligibility_description"><?php echo htmlspecialchars($job['eligibility_description']); ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Selection Mode:</legend>
                <?php
                $selected_selection_mode = $job['selection_mode'];
                ?>
                <label><input type="radio" name="selection_mode" value="On-campus" <?php if ($selected_selection_mode == "On-campus") echo "checked"; ?> required> On-campus</label>
                <label><input type="radio" name="selection_mode" value="Virtual-Mode" <?php if ($selected_selection_mode == "Virtual-Mode") echo "checked"; ?> required> Virtual-Mode</label>

                <label for="selection_mode_description">Description:</label>
                <textarea id="selection_mode_description" name="selection_mode_description"><?php echo htmlspecialchars($job['selection_mode_description']); ?></textarea>
            </fieldset>

            <label for="selection_process">Selection Process:</label>
            <textarea id="selection_process" name="selection_process" required><?php echo htmlspecialchars($job['selection_process']); ?></textarea>

            <label for="selection_date">Selection Date:</label>
            <input type="date" id="selection_date" name="selection_date" value="<?php echo htmlspecialchars($job['selection_date']); ?>" >

            <label for="designation">Designation:</label>
            <input type="text" id="designation" name="designation" value="<?php echo htmlspecialchars($job['designation']); ?>" required>

            <label for="remuneration">Remuneration:</label>
            <input type="text" id="remuneration" name="remuneration" value="<?php echo htmlspecialchars($job['remuneration']); ?>" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($job['location']); ?>" required>

            <label for="class_x_percentage">Class X Percentage:</label>
            <input type="number" step="0.01" id="class_x_percentage" name="class_x_percentage" value="<?php echo htmlspecialchars($job['class_x_percentage']); ?>" required>

            <label for="class_xii_percentage">Class XII Percentage:</label>
            <input type="number" step="0.01" id="class_xii_percentage" name="class_xii_percentage" value="<?php echo htmlspecialchars($job['class_xii_percentage']); ?>" required>

            <label for="graduation_cgpa">Graduation CGPA:</label>
            <input type="number" step="0.01" id="graduation_cgpa" name="graduation_cgpa" value="<?php echo htmlspecialchars($job['graduation_cgpa']); ?>" required>

            <label for="postgraduation_cgpa">Postgraduation CGPA:</label>
            <input type="number" step="0.01" id="postgraduation_cgpa" name="postgraduation_cgpa" value="<?php echo htmlspecialchars($job['postgraduation_cgpa']); ?>" >

            <div class="button-group">
                <input type="submit" name="update" value="Update" onclick="return confirm('Are you sure you want to update this job?');">
                <input type="submit" name="remove" value="Remove" class="remove-button" onclick="return confirm('Are you sure you want to remove this job posting?');">
            </div>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
