<?php
include_once("../../../php/connection.php");

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Search and filter variables
$search_roll = isset($_POST['search_roll']) ? $_POST['search_roll'] : '';
$search_job_id = isset($_POST['search_job_id']) ? $_POST['search_job_id'] : '';
$filter_dept = isset($_POST['filter_dept']) ? $_POST['filter_dept'] : '';
$filter_specialisation = isset($_POST['filter_specialisation']) ? $_POST['filter_specialisation'] : '';

// Pagination variables
$limit = 10;  // Number of entries per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Build the query
$sql = "SELECT applications.*, students.StudentName, students.StudentDept, students.StudentSpecialisation, job_posting.recruiting_company 
        FROM applications
        JOIN students ON applications.student_roll = students.StudentRoll
        JOIN job_posting ON applications.job_post_id = job_posting.id
        WHERE (applications.student_roll LIKE ? OR applications.job_post_id LIKE ?)
        OR (students.StudentDept LIKE ?)
        OR (students.StudentSpecialisation LIKE ?)
        LIMIT ?, ?";
        
$stmt = $conn->prepare($sql);
$like_roll = "%" . $search_roll . "%";
$like_job_id = "%" . $search_job_id . "%";
$like_dept = "%" . $filter_dept . "%";
$like_specialisation = "%" . $filter_specialisation . "%";
$stmt->bind_param("ssssii", $like_roll, $like_job_id, $like_dept, $like_specialisation, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

// Get total number of records for pagination
$total_sql = "SELECT COUNT(*) as total FROM applications
              JOIN students ON applications.student_roll = students.StudentRoll
              JOIN job_posting ON applications.job_post_id = job_posting.id
              WHERE (applications.student_roll LIKE ? OR applications.job_post_id LIKE ?)
              OR (students.StudentDept LIKE ?)
              OR (students.StudentSpecialisation LIKE ?)";
$total_stmt = $conn->prepare($total_sql);
$total_stmt->bind_param("ssss", $like_roll, $like_job_id, $like_dept, $like_specialisation);
$total_stmt->execute();
$total_result = $total_stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Listings</title>
    <link rel="stylesheet" href="../../../css/nav.css">
    <link rel="stylesheet" href="list_applications.css">
</head>
<body>
    <div class="topnav" id="home-topnav">
        <nav>
            <a href="../admin_logout.php" class="split">Sign Out</a>
            <a href="../admin_home.php">Home</a>
        </nav>
    </div>
    <div class="container">
        <h1>Application Listings</h1>
        <form method="post" action="">
            <input type="text" name="search_roll" placeholder="Search by Student Roll" value="<?php echo htmlspecialchars($search_roll ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <input type="text" name="search_job_id" placeholder="Search by Job ID" value="<?php echo htmlspecialchars($search_job_id ?? '', ENT_QUOTES, 'UTF-8'); ?>">
            <select name="filter_dept">
                <option value="">All Departments</option>
                <option value="BTech" <?php if($filter_dept == 'BTech') echo 'selected'; ?>>BTech</option>
                <option value="MCA" <?php if($filter_dept == 'MCA') echo 'selected'; ?>>MCA</option>
                <option value="MTech" <?php if($filter_dept == 'MTech') echo 'selected'; ?>>MTech</option>
                <option value="BE" <?php if($filter_dept == 'BE') echo 'selected'; ?>>BE</option>
            </select>
            <select name="filter_specialisation">
                <option value="">All Specialisations</option>
                <option value="AEIE" <?php if($filter_specialisation == 'AEIE') echo 'selected'; ?>>AEIE</option>
                <option value="CSBS" <?php if($filter_specialisation == 'CSBS') echo 'selected'; ?>>CSBS</option>
                <option value="CSE" <?php if($filter_specialisation == 'CSE') echo 'selected'; ?>>CSE</option>
                <option value="DS" <?php if($filter_specialisation == 'DS') echo 'selected'; ?>>DS</option>
                <option value="AIML" <?php if($filter_specialisation == 'AIML') echo 'selected'; ?>>AIML</option>
                <option value="CE" <?php if($filter_specialisation == 'CE') echo 'selected'; ?>>CE</option>
                <option value="IT" <?php if($filter_specialisation == 'IT') echo 'selected'; ?>>IT</option>
                <option value="ECE" <?php if($filter_specialisation == 'ECE') echo 'selected'; ?>>ECE</option>
                <option value="EE" <?php if($filter_specialisation == 'EE') echo 'selected'; ?>>EE</option>
            </select>
            <input type="submit" value="Search">
        </form>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Application ID</th>
                        <th>Student Roll</th>
                        <th>Student Name</th>
                        <th>Department</th>
                        <th>Specialisation</th>
                        <th>Job ID</th>
                        <th>Company</th>
                        <th>Application Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['application_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['student_roll'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['StudentName'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['StudentDept'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['StudentSpecialisation'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['job_post_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['recruiting_company'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['application_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($row['application_status'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <form method="post" action="update_application_status.php">
                                    <input type="hidden" name="application_id" value="<?php echo htmlspecialchars($row['application_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                                    <select name="new_status">
                                        <option value="Applied" <?php if ($row['application_status'] == 'Applied') echo 'selected'; ?>>Applied</option>
                                        <option value="Shortlisted" <?php if ($row['application_status'] == 'Shortlisted') echo 'selected'; ?>>Shortlisted</option>
                                        <option value="Rejected" <?php if ($row['application_status'] == 'Rejected') echo 'selected'; ?>>Rejected</option>
                                        <option value="Selected" <?php if ($row['application_status'] == 'Selected') echo 'selected'; ?>>Selected</option>
                                    </select>
                                    <input type="submit" value="Update Status">
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a href="list_applications.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </div>
        <?php else: ?>
            <p>No applications found.</p>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
