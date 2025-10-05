<?php
session_start();
include "db_connect.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$id = intval($_GET['id']);

// Fetch existing trip data
$stmt = $conn->prepare("SELECT * FROM trips WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$trip = $result->fetch_assoc();
$stmt->close();

if (!$trip) {
    echo "Trip not found!";
    exit;
}

// Initialize variables
$name = $trip['name'];
$description = $trip['description'];
$trip_date = $trip['trip_date'];
$location = $trip['location'];
$status = $trip['status'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $trip_date = $_POST['trip_date'];
    $location = $_POST['location'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE trips SET name=?, description=?, trip_date=?, location=?, status=? WHERE id=?");
    $stmt->bind_param("sssssi", $name, $description, $trip_date, $location, $status, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: admin_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Trip - TravelEase</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
<style>
body { font-family: 'Poppins', sans-serif; background-color: #fcfcfb; margin: 0; }
header { background-color: #05314e; color: #c1f8f8; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
header h1 { margin: 0; font-size: 2rem; }
nav a { color: white; text-decoration: none; margin-left: 20px; font-weight: 500; padding: 6px 12px; border-radius: 5px; }
nav a:hover { background-color: #a4dbf4; color: #05314e; }
main { max-width: 700px; margin: 50px auto; background-color: #e9f6fd; padding: 30px; border-radius: 10px; }
form label { display: block; margin: 12px 0 4px; font-weight: 500; }
form input[type="text"], form input[type="date"], form textarea, form select { width: 100%; padding: 10px; border-radius: 6px; border: 1px solid #ccc; box-sizing: border-box; }
form textarea { resize: vertical; min-height: 80px; }
form button { background-color: #033554; color: white; border: none; padding: 12px 20px; border-radius: 6px; cursor: pointer; margin-top: 20px; font-size: 1rem; }
form button:hover { background-color: #06527d; }
footer { background-color: #084d74; color: white; text-align: center; padding: 15px 0; margin-top: 50px; }
</style>
</head>
<body>
<header>
<h1>TravelEase Admin</h1>
<nav>
<a href="admin_dashboard.php">Dashboard</a>
<a href="logout.php">Logout</a>
</nav>
</header>

<main>
<h2>Edit Trip</h2>
<form method="post">
    <label for="name">Trip Name</label>
    <input type="text" name="name" id="name" required value="<?= htmlspecialchars($name) ?>">

    <label for="description">Description</label>
    <textarea name="description" id="description" required><?= htmlspecialchars($description) ?></textarea>

    <label for="trip_date">Date</label>
    <input type="date" name="trip_date" id="trip_date" required value="<?= htmlspecialchars($trip_date) ?>">

    <label for="location">Location</label>
    <input type="text" name="location" id="location" required value="<?= htmlspecialchars($location) ?>">

    <label for="status">Status</label>
    <select name="status" id="status">
        <option value="upcoming" <?= $status==='upcoming'?'selected':'' ?>>Upcoming</option>
        <option value="past" <?= $status==='past'?'selected':'' ?>>Past</option>
        <option value="cancelled" <?= $status==='cancelled'?'selected':'' ?>>Cancelled</option>
    </select>

    <button type="submit">Update Trip</button>
</form>
</main>

<footer>
2025 TravelEase – All rights reserved
</footer>
</body>
</html>
