<?php
session_start();
include "db_connect.php";

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch user details from DB
$stmt = $conn->prepare("SELECT fullname, email, mobile FROM users WHERE id=?");
$stmt->bind_param("i", $user_id);
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
    <title>Profile - TravelEase</title>
    <link rel="stylesheet" href="hcss.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f5f9fb;
            display: flex;
            flex-direction: column;
        }

        .navbar{display:flex;justify-content:space-between;flex-wrap:wrap;padding:15px;background-color:#05314e}
        .nav-left,.nav-right{display:flex;flex-wrap:wrap;align-items:center}
        .nav-left a,.nav-right a{color:#fff;text-decoration:none;margin:0 15px;font-weight:500;padding:5px 10px;border-radius:5px}
        .nav-left a:hover,.nav-right a:hover{background:#a4dbf4;color:#05314e}

        .profile-wrapper { flex: 1; display:flex; justify-content:center; align-items:center; padding:20px; }
        .profile-container { width:100%; max-width:600px; background-color: #e9f6fd; border-radius:10px; padding:60px 20px 30px; text-align:center; position:relative; }
        .profile-logo { width:120px; height:120px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:-90px auto 10px; background:linear-gradient(135deg,#48c6ef 0%,#6f86d6 100%); box-shadow:0 6px 18px rgba(7,32,63,0.18); border:6px solid #fff; }
        .profile-logo svg { width:64px; height:64px; fill:#fff; }
        h2 { color:#043d57; margin:10px 0 20px; }
        p { font-size:16px; margin:8px 0; color:#043d57; }
        .btn { padding:12px 20px; margin:10px 5px; border:none; border-radius:5px; cursor:pointer; color:white; font-weight:bold; text-decoration:none; display:inline-block; }
        .btn-home { background-color:#048488; }
        .btn-logout { background-color:#d9534f; }

        footer { background-color:#084d74; color:#fff; text-align:center; padding:15px 0; }
    </style>
</head>
<body>

<header>
    <div style="background-color: rgba(12, 81, 131, 0.935);">
      <a href="h.html" style="text-decoration:none;"><h1 style="color:#c1f8f8; padding:10px; margin:0;">TravelEase</h1></a>
    </div>
    <nav class="navbar">
        <div class="nav-left">
            <a href="h.php">Home</a>
            <a href="search.html">Search</a>
            <a href="trippreview.html">Trip Review</a>
            <a href="highlighted.html">Highlighted Trips</a>
            <a href="pre-req.html">Pre-requisites</a>
            <a href="faq.html">FAQ</a>
            <a href="offer.html">Offers</a>
        </div>
        <div class="nav-right">
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
            <a href="aboutus.html">About Us</a>
            <a href="contact.html">Contact</a>
        </div>
    </nav>
</header>

<div class="profile-wrapper">
    <div class="profile-container">
        <div class="profile-logo">
            <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                <text x="32" y="46" font-family="Poppins, Arial" font-size="16" font-weight="700" text-anchor="middle" fill="#fff">TE</text>
            </svg>
        </div>
        <h2>Welcome, <?php echo htmlspecialchars($fullname); ?>!</h2>
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($fullname); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>Mobile:</strong> <?php echo htmlspecialchars($mobile); ?></p>

        <div>
            <a href="h.php" class="btn btn-home">Home</a>
            <a href="logout.php" class="btn btn-logout">Logout</a>
        </div>
    </div>
</div>

<footer>
    2025 TravelEase – All rights reserved
</footer>

</body>
</html>
