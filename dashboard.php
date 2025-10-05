<?php
session_start();

// Session timeout: 10 minutes
$timeout_duration = 600;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if (isset($_SESSION['last_activity']) && 
    (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: login.html?timeout=1");
    exit();
}

$_SESSION['last_activity'] = time(); // update last activity time

// Fetch user info from database
include "db_connect.php";
$stmt = $conn->prepare("SELECT fullname, email, mobile FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($fullname, $email, $mobile);
$stmt->fetch();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard - TravelEase</title>
  <link rel="stylesheet" href="hcss.css">
  <style>
    #session-timer {
      position: fixed;
      top: 20px;
      right: 20px;
      background: #048488;
      color: white;
      padding: 10px 15px;
      border-radius: 5px;
      font-weight: bold;
      font-family: Arial, sans-serif;
      z-index: 1000;
    }
  </style>
</head>
<body style="font-family: Arial;">
<div id="session-timer"></div> <!-- Timer will appear here -->

<header>
  <h1 style="text-align: center; color: #eeeeeeff;">Welcome to TravelEase, <?php echo htmlspecialchars($fullname); ?>!</h1>
</header>

<main>
  <div style="max-width: 400px; margin: 50px auto; padding: 40px; background-color: #e9f6fd; border-radius: 10px; text-align: center;">
    <h2>Your Details</h2>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($fullname); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Mobile:</strong> <?php echo htmlspecialchars($mobile); ?></p>

    <div style="margin-top: 30px;">
      <a href="logout.php">
        <button style="padding: 12px 20px; margin-right: 10px; background-color: #d9534f; color: white; border: none; border-radius: 5px; cursor: pointer;">Logout</button>
      </a>
      <a href="h.html">
        <button style="padding: 12px 20px; background-color: #048488; color: white; border: none; border-radius: 5px; cursor: pointer;">Home</button>
      </a>
    </div>
  </div>
</main>

<footer style="text-align: center; margin-top: 200px;">
  <p>2025 TravelEase all rights reserved</p>
</footer>

<script>
let timeoutDuration = <?php echo $timeout_duration; ?>; // seconds
let lastActivity = <?php echo $_SESSION['last_activity']; ?>;
let endTime = lastActivity + timeoutDuration;

function updateTimer() {
    let now = Math.floor(Date.now() / 1000);
    let remaining = endTime - now;

    if (remaining <= 0) {
        window.location.href = "login.html?timeout=1";
        return;
    }

    let minutes = Math.floor(remaining / 60);
    let seconds = remaining % 60;
    document.getElementById('session-timer').textContent = 
        `Session Timeout: ${minutes.toString().padStart(2,'0')}:${seconds.toString().padStart(2,'0')}`;
}

setInterval(updateTimer, 1000);
updateTimer();
</script>
</body>
</html>
