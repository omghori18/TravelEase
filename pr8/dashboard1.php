<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login1.php");
    exit();
}

include 'db1.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - TraveLease</title>
</head>
<body>
    <h2>Welcome to TraveLease, <?php echo $_SESSION['user_name']; ?> 🎉</h2>

    <h3>Latest 5 Travel Packages:</h3>
    <?php
    $sql = "SELECT * FROM events ORDER BY event_date DESC LIMIT 5";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><b>" . $row['event_name'] . "</b> - " . $row['location'] . " - ₹" . $row['price'] . "</p>";
        }
    } else {
        echo "<p>No events found.</p>";
    }
    ?>

    <a href="logout.php">Logout</a>
</body>
</html>
