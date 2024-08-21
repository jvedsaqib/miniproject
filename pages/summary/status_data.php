<?php 
include_once('../../php/connection.php');

$sql = "SELECT placement_status, COUNT(*) as num_students FROM placements GROUP BY placement_status";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

$statuses = [];
$counts = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statuses[] = $row["placement_status"];
        $counts[] = $row["num_students"];
    }
}
$conn->close();

echo json_encode([
    'labels' => $statuses,
    'values' => $counts
]);
?>
