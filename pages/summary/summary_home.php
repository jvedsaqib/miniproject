<?php 
include_once('../../php/connection.php');

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
    <title>Summary</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@latest"></script>
    <link rel="stylesheet" href="../../css/nav.css">
    <link rel="stylesheet" href="summary_home.css">
</head>
<body>
    <div class="topnav">
        <nav>
            <a href="../../home.php">Home</a> 
            <a href="">Summary</a> 
            <a href="../student_login.php">Student Login</a> 
            <a href="../admin_login.php" class="split">Admin Login</a>
        </nav>
    </div>

    <h1>Placement Summary</h1>
    <div class="chart-row">
        <div class="chart-container">
            <h2>Number of Students Placed by Company</h2>
            <canvas id="placementChart"></canvas>
        </div>
        <div class="chart-container">
            <h2>Placement Status Distribution</h2>
            <canvas id="statusChart"></canvas>
        </div>
    </div>

    <div class="chart-row">
        <div class="chart-container">
            <h2>Number of Placements Over Time</h2>
            <canvas id="timeChart"></canvas>
        </div>
        <div class="chart-container">
            <h2>Number of Students Placed by Department</h2>
            <canvas id="departmentChart"></canvas>
        </div>
    </div>

    <div class="chart-row">
        <div class="chart-container">
            <h2>Number of BTech Students Placed by Specialisation</h2>
            <canvas id="specialisationChart"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx1 = document.getElementById('placementChart').getContext('2d');
            const ctx3 = document.getElementById('statusChart').getContext('2d');
            const ctx4 = document.getElementById('timeChart').getContext('2d');
            const ctx5 = document.getElementById('departmentChart').getContext('2d');
            const ctx6 = document.getElementById('specialisationChart').getContext('2d');

            const colors = [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                '#9966FF', '#FF9F40', '#FF6F61', '#6B5B95',
                '#8B8D8F', '#D4A5A5', '#61C0BF', '#F3A712'
            ];

            // Placement Chart
            new Chart(ctx1, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($companies); ?>,
                    datasets: [{
                        label: 'Number of Students Placed',
                        data: <?php echo json_encode($student_counts); ?>,
                        backgroundColor: colors.slice(0, <?php echo count($companies); ?>),
                        borderColor: colors.slice(0, <?php echo count($companies); ?>),
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
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: ${tooltipItem.raw}`;
                                }
                            }
                        }
                    }
                }
            });

            // Status Chart
            fetch('status_data.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    new Chart(ctx3, {
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Placement Status',
                                data: data.values,
                                backgroundColor: colors.slice(0, data.labels.length),
                                borderColor: colors.slice(0, data.labels.length),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return `${tooltipItem.label}: ${tooltipItem.raw}`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error loading status data:', error));

            // Time Chart
            fetch('time_data.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    new Chart(ctx4, {
                        type: 'line',
                        data: {
                            labels: data.dates,
                            datasets: [{
                                label: 'Number of Placements',
                                data: data.counts,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return `Date: ${tooltipItem.label}, Placements: ${tooltipItem.raw}`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    type: 'time',
                                    time: {
                                        unit: 'year'
                                    }
                                },
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error loading time data:', error));

            // Department Chart
            new Chart(ctx5, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($departments); ?>,
                    datasets: [{
                        label: 'Number of Students Placed by Department',
                        data: <?php echo json_encode($dept_counts); ?>,
                        backgroundColor: colors.slice(0, <?php echo count($departments); ?>),
                        borderColor: colors.slice(0, <?php echo count($departments); ?>),
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
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: ${tooltipItem.raw}`;
                                }
                            }
                        }
                    }
                }
            });

            // Specialisation Chart
            new Chart(ctx6, {
                type: 'pie',
                data: {
                    labels: <?php echo json_encode($specialisations); ?>,
                    datasets: [{
                        label: 'Number of BTech Students Placed by Specialisation',
                        data: <?php echo json_encode($spec_counts); ?>,
                        backgroundColor: colors.slice(0, <?php echo count($specialisations); ?>),
                        borderColor: colors.slice(0, <?php echo count($specialisations); ?>),
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
                                label: function(tooltipItem) {
                                    return `${tooltipItem.label}: ${tooltipItem.raw}`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
