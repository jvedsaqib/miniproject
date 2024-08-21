<?php 
include_once('../../php/connection.php');

$sql = "SELECT DATE_FORMAT(placement_date, '%Y') as year, COUNT(*) as num_students FROM placements GROUP BY year;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$dates = [];
$counts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $dates[] = $row["year"];
        $counts[] = $row["num_students"];
    }
}
$conn->close();

echo json_encode([
    'dates' => $dates,
    'counts' => $counts
]);
?>
