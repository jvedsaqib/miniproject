<?php 
include_once('php/connection.php');

session_start();
$_SESSION = array();
session_destroy();

error_reporting(E_ALL);
ini_set('display_errors', 1);

$sql = "SELECT company_name, COUNT(*) as num_students FROM placements GROUP BY company_name";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$companies = [];
$student_counts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $companies[] = $row["company_name"];
        $student_counts[] = $row["num_students"];
    }
}

$sql_dept = "SELECT StudentDept, COUNT(*) as num_students FROM placements GROUP BY StudentDept";
$stmt_dept = $conn->prepare($sql_dept);
$stmt_dept->execute();
$result_dept = $stmt_dept->get_result();

$departments = [];
$dept_counts = [];

if ($result_dept->num_rows > 0) {
    while ($row = $result_dept->fetch_assoc()) {
        $departments[] = $row["StudentDept"];
        $dept_counts[] = $row["num_students"];
    }
}

$sql_spec = "SELECT StudentSpecialisation, COUNT(*) as num_students FROM placements WHERE StudentDept = 'BTech' GROUP BY StudentSpecialisation";
$stmt_spec = $conn->prepare($sql_spec);
$stmt_spec->execute();
$result_spec = $stmt_spec->get_result();

$specialisations = [];
$spec_counts = [];

if ($result_spec->num_rows > 0) {
    while ($row = $result_spec->fetch_assoc()) {
        $specialisations[] = $row["StudentSpecialisation"];
        $spec_counts[] = $row["num_students"];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/nav.css">
    <link rel="stylesheet" href="css/summary_home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@latest"></script>
</head>
<body>

    <div class="topnav" id="home-topnav">
        <nav>
            <a class="active" href="#">Home</a> 
            <a href="pages/student_login.php">Student Login</a> 
            <a href="pages/admin_login.php" class="split">Admin Login</a>
            <a href="javascript:void(0);" class="icon" onclick="myFunction()">
                <i class="fa fa-bars"></i>
            </a> 
        </nav>
    </div>

    <h1>Placement Summary</h1>

    <!-- Search bars -->
    <div class="search-container">
        <input type="text" id="companySearch" class="search-input" placeholder="Search by Company Name">
        <input type="text" id="deptSearch" class="search-input" placeholder="Search by Department">
    </div>

    <div class="chart-row">
        <div class="chart-container">
            <h2>Number of Students Placed by Company</h2>
            <canvas id="placementChart"></canvas>
        </div>
        <div class="chart-container">
            <h2>Number of Students Placed by Department</h2>
            <canvas id="departmentChart"></canvas>
        </div>
    </div>

    <div class="chart-row">
        <div class="chart-container">
            <h2>Number of Placements Over Time</h2>
            <canvas id="timeChart"></canvas>
        </div>
        <div class="chart-container">
            <h2>Number of BTech Students Placed by Specialisation</h2>
            <canvas id="specialisationChart"></canvas>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const companies = <?php echo json_encode($companies); ?>;
            const studentCounts = <?php echo json_encode($student_counts); ?>;
            const departments = <?php echo json_encode($departments); ?>;
            const deptCounts = <?php echo json_encode($dept_counts); ?>;
            const specialisations = <?php echo json_encode($specialisations); ?>;
            const specCounts = <?php echo json_encode($spec_counts); ?>;
            
            const colors = [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                '#9966FF', '#FF9F40', '#FF6F61', '#6B5B95',
                '#8B8D8F', '#D4A5A5', '#61C0BF', '#F3A712'
            ];

            // Function to create chart
            const createChart = (ctx, type, labels, data, colorSlice, labelName) => {
                return new Chart(ctx, {
                    type: type,
                    data: {
                        labels: labels,
                        datasets: [{
                            label: labelName,
                            data: data,
                            backgroundColor: colors.slice(0, colorSlice),
                            borderColor: colors.slice(0, colorSlice),
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'right',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return `${tooltipItem.label}: ${tooltipItem.raw}`;
                                    }
                                }
                            }
                        }
                    }
                });
            };

            // Initial chart creation
            let placementChart = createChart(
                document.getElementById('placementChart').getContext('2d'),
                'pie', companies, studentCounts, companies.length, 'Number of Students Placed'
            );
            let departmentChart = createChart(
                document.getElementById('departmentChart').getContext('2d'),
                'pie', departments, deptCounts, departments.length, 'Number of Students Placed by Department'
            );
            let specialisationChart = createChart(
                document.getElementById('specialisationChart').getContext('2d'),
                'pie', specialisations, specCounts, specialisations.length, 'Number of BTech Students Placed'
            );
            
            fetch('pages/summary/time_data.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Use the createChart function to generate the time chart
                    createChart(
                        document.getElementById('timeChart').getContext('2d'),
                        'line',                           
                        data.dates,                       
                        data.counts,                      
                        data.dates.length,                
                        'Number of Placements'
                    );
                })
                .catch(error => console.error('Error loading time data:', error));


            // Search filtering logic
            document.getElementById('companySearch').addEventListener('input', function () {
                const searchValue = this.value.toLowerCase();
                const filteredCompanies = companies.filter(c => c.toLowerCase().includes(searchValue));
                const filteredCounts = companies.map((c, i) => c.toLowerCase().includes(searchValue) ? studentCounts[i] : 0);

                placementChart.destroy(); // Destroy the old chart
                placementChart = createChart(
                    document.getElementById('placementChart').getContext('2d'),
                    'pie', filteredCompanies, filteredCounts, filteredCompanies.length, 'Number of Students Placed'
                );
            });

            document.getElementById('deptSearch').addEventListener('input', function () {
                const searchValue = this.value.toLowerCase();
                const filteredDepartments = departments.filter(d => d.toLowerCase().includes(searchValue));
                const filteredDeptCounts = departments.map((d, i) => d.toLowerCase().includes(searchValue) ? deptCounts[i] : 0);

                departmentChart.destroy(); // Destroy the old chart
                departmentChart = createChart(
                    document.getElementById('departmentChart').getContext('2d'),
                    'pie', filteredDepartments, filteredDeptCounts, filteredDepartments.length, 'Number of Students Placed by Department'
                );
            });
        });
    </script>

    <footer>
        <div class="footer-container">
            <div class="footer-content">
                <p><strong>Contact Us:</strong> Email: jvedsaqib@gmail.com | Phone: +91 6291526612</p>
                <p><strong>TPO Office Hours:</strong> Mon - Fri: 9:00 AM - 6:00 PM</p>
                <p>&copy; 2024 Job Portal. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>

<script>
    function myFunction() {
        var x = document.getElementById("home-topnav");
        if (x.className === "topnav") {
            x.className += " responsive";
        } else {
            x.className = "topnav";
        }
    }
</script>
