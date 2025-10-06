<?php
header("Content-Type: application/json");
include "db_connect.php";

// Fetch all trips
$sql = "SELECT id, name, trip_date, location, status FROM trips ORDER BY trip_date DESC";
$result = $conn->query($sql);

$events = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            "name" => $row['name'],
            "description" => "", // no description in your table
            "date" => $row['trip_date'],
            "location" => $row['location'],
            "status" => $row['status'],
            "poster" => "default.jpg" // placeholder image for now
        ];
    }
}

echo json_encode($events);
$conn->close();
?>
