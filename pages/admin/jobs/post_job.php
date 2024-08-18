<?php
   include_once('../admin_session.php');
   include_once('../../../php/connection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST JOB</title>
    <link rel="stylesheet" href="../../../css/nav.css">
    <link rel="stylesheet" href="post_job.css">
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
        <form action="submit_job.php" method="POST" onsubmit="return confirmSubmit();">
            <h2>Job Posting Details</h2>

            <label for="reference_number">Reference Number:</label>
            <input type="text" id="reference_number" name="reference_number" required>

            <label for="post_date">Date:</label>
            <input type="date" id="post_date" name="post_date" required>

            <label for="batch_year">Batch Year:</label>
            <input type="number" id="batch_year" name="batch_year" min="2000" max="2099" required>

            <label for="recruiting_company">Recruiting Company:</label>
            <input type="text" id="recruiting_company" name="recruiting_company" required>

            <fieldset>
                <legend>Streams Considered:</legend>
                <label><input type="checkbox" name="streams[]" value="Btech"> Btech</label><br>
                <div class="sub-checkbox">
                    <label><input type="checkbox" name="streams[]" value="AEIE"> AEIE</label>
                    <label><input type="checkbox" name="streams[]" value="CSBS"> CSBS</label>
                    <label><input type="checkbox" name="streams[]" value="CSE"> CSE</label>
                    <label><input type="checkbox" name="streams[]" value="DS"> DS</label>
                    <label><input type="checkbox" name="streams[]" value="AIML"> AIML</label>
                    <label><input type="checkbox" name="streams[]" value="CE"> CE</label>
                    <label><input type="checkbox" name="streams[]" value="IT"> IT</label>
                    <label><input type="checkbox" name="streams[]" value="ECE"> ECE</label>
                    <label><input type="checkbox" name="streams[]" value="EE"> EE</label>
                </div>
                <label><input type="checkbox" name="streams[]" value="MCA"> MCA</label><br>
                <label><input type="checkbox" name="streams[]" value="MTECH"> MTECH</label>
            </fieldset>

            <fieldset>
                <legend>Eligibility Criteria:</legend>
                <label for="backlogs">Number of Backlogs:</label>
                <input type="number" id="backlogs" name="backlogs" min="0" required>

                <label for="minimum_cgpa">Minimum CGPA:</label>
                <input type="number" id="minimum_cgpa" name="minimum_cgpa" step="0.01" required>

                <label for="eligibility_description">Description:</label>
                <textarea id="eligibility_description" name="eligibility_description"></textarea>
            </fieldset>

            <fieldset>
                <legend>Selection Mode:</legend>
                <label><input type="radio" name="selection_mode" value="On-campus" required> On-campus</label>
                <label><input type="radio" name="selection_mode" value="Virtual-Mode" required> Virtual-Mode</label>

                <label for="selection_mode_description">Description:</label>
                <textarea id="selection_mode_description" name="selection_mode_description"></textarea>
            </fieldset>

            <label for="selection_process">Selection Process:</label>
            <textarea type="text" id="selection_process" name="selection_process" required></textarea>

            <label for="selection_date">Selection Date:</label>
            <textarea type="text" id="selection_date" name="selection_date" required></textarea>

            <label for="designation">Designation:</label>
            <textarea type="text" id="designation" name="designation" required></textarea>

            <label for="remuneration">Remuneration:</label>
            <textarea type="text" id="remuneration" name="remuneration" required></textarea>

            <label for="location">Location:</label>
            <textarea type="text" id="location" name="location" required></textarea>

            <label for="class_x_percentage">Class X Percentage:</label>
            <input type="number" step="0.01" name="class_x_percentage" required><br><br>

            <label for="class_xii_percentage">Class XII Percentage:</label>
            <input type="number" step="0.01" name="class_xii_percentage" required><br><br>

            <label for="graduation_cgpa">Graduation CGPA:</label>
            <input type="number" step="0.01" name="graduation_cgpa" required><br><br>

            <label for="postgraduation_cgpa">Postgraduation CGPA:</label>
            <input type="number" step="0.01" name="postgraduation_cgpa" required><br><br>

            <button type="submit">Submit Job Posting</button>
        </form>
    </div>
</body>
</html>

<script>

    function confirmSubmit() {
        return confirm("Are you sure you want to post this job?");
    }

</script>