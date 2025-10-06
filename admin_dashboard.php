<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "db_connect.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");
    exit;
}

// Fetch all events
$result = $conn->query("SELECT * FROM trips ORDER BY trip_date DESC");

// Make sure reg_time exists before fetching users
$user_check = $conn->query("SHOW COLUMNS FROM users LIKE 'reg_time'");
if ($user_check->num_rows == 0) {
    $conn->query("ALTER TABLE users ADD COLUMN reg_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
}

// Fetch all users
$user_result = $conn->query("SELECT id, fullname, email, mobile, reg_time FROM users ORDER BY reg_time DESC");
if(!$user_result) {
    die("Error fetching users: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>TravelEase - Admin Dashboard</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
<style>
html, body { height: 100%; margin:0; font-family: 'Poppins', sans-serif; }
body { display: flex; flex-direction: column; background-color: #f7f6f5; }
header { background-color: #05314e; color: #c1f8f8; padding: 15px 30px; display:flex; justify-content:space-between; align-items:center; }
header h1 { margin:0; font-size:2rem; }
nav a { color:white; text-decoration:none; margin-left:20px; padding:6px 12px; border-radius:5px; font-weight:500; }
nav a:hover { background-color:#a4dbf4; color:#05314e; }
main { flex:1; padding:30px; max-width:1200px; margin:auto; box-sizing:border-box; }
table { width:100%; border-collapse: collapse; margin-top:20px; background-color:#e9f6fd; border-radius:10px; overflow:hidden; }
th, td { padding:12px 15px; text-align:left; }
th { background-color:#048488; color:white; }
tr:nth-child(even) { background-color:#d4f1f9; }
tr:hover { background-color:#b1e5f0; }
a.button { display:inline-block; background-color:#033554; color:white; padding:8px 14px; border-radius:6px; text-decoration:none; margin-top:10px; }
a.button:hover { background-color:#06527d; }
footer { background-color:#084d74; color:white; text-align:center; padding:15px 0; margin-top:auto; }
</style>
</head>
<body>

<header>
<h1>TravelEase Admin Dashboard</h1>
<nav>
    <a href="admin_dashboard.php">Events</a>
    <a href="highlighted_trips.php">Highlighted Trips</a>
    <a href="logout.php">Logout</a>
</nav>
</header>

<main>
<h2>Manage Events</h2>
<a href="add_event.php" class="button">Add New Event</a>

<table>
<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Date</th>
    <th>Location</th>
    <th>Status</th>
    <th>Actions</th>
</tr>
<?php while($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= $row['id']; ?></td>
    <td><?= htmlspecialchars($row['name']); ?></td>
    <td><?= htmlspecialchars($row['trip_date']); ?></td>
    <td><?= htmlspecialchars($row['location']); ?></td>
    <td><?= htmlspecialchars($row['status']); ?></td>
    <td>
        <a href="edit_event.php?id=<?= $row['id']; ?>" class="button">Edit</a>
        <a href="delete_event.php?id=<?= $row['id']; ?>" class="button" onclick="return confirm('Delete this event?')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

<h2 style="margin-top:50px;">Manage Users</h2>
<table>
<tr>
    <th>ID</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Mobile</th>
    <th>Registered On</th>
    <th>Actions</th>
</tr>
<?php while($user = $user_result->fetch_assoc()): ?>
<tr>
    <td><?= $user['id']; ?></td>
    <td><?= htmlspecialchars($user['fullname']); ?></td>
    <td><?= htmlspecialchars($user['email']); ?></td>
    <td><?= htmlspecialchars($user['mobile']); ?></td>
    <td><?= htmlspecialchars($user['reg_time']); ?></td>
    <td>
        <a href="delete_user.php?id=<?= $user['id']; ?>" class="button" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
    </td>
</tr>
<?php endwhile; ?>
</table>

</main>

<footer>
2025 TravelEase – All rights reserved
</footer>

</body>
</html>
