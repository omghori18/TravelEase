<?php
include 'db1.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Simple query, use prepared statements in production for security
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Set session
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];

        // Redirect to dashboard
        header("Location: dashboard1.php");
        exit();
    } else {
        $error = "❌ Invalid login details.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - TraveLease</title>
</head>
<body>
    <h2>Login to TraveLease</h2>

    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <form method="POST" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register1.php">Register Here</a></p>
</body>
</html>
