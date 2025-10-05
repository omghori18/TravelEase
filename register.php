<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captcha validation
    $enteredCaptcha = $_POST['captchaInput'] ?? '';
    $hiddenCaptcha = $_POST['captcha_hidden'] ?? '';

    if (strcasecmp(trim($enteredCaptcha), trim($hiddenCaptcha)) !== 0) {
        echo "<script>alert('❌ Invalid Captcha! Please try again.'); window.history.back();</script>";
        exit;
    }

    // Sanitize user input
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $mobile   = htmlspecialchars(trim($_POST['mobile']));
    $email    = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('⚠️ Email already registered! Try another.'); window.history.back();</script>";
        exit;
    }

    // Insert new user into database
    $stmt = $conn->prepare("INSERT INTO users (fullname, mobile, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $fullname, $mobile, $email, $hashed_password);

    if ($stmt->execute()) {
        // Save record to data.txt (optional)
        $record_file = __DIR__ . "/data.txt";

        if (!file_exists($record_file)) {
            $headers = "Full Name,Mobile,Email,Password Hash,Registration Time\n";
            file_put_contents($record_file, $headers, FILE_APPEND);
        }

        $record = $fullname . "," . $mobile . "," . $email . "," . $hashed_password . "," . date("Y-m-d H:i:s") . "\n";
        file_put_contents($record_file, $record, FILE_APPEND);

        echo "<script>
                alert('✅ Registration Successful! Please login.');
                window.location.href='login.html';
              </script>";
    } else {
        echo "<script>alert('❌ Error while registering. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $check->close();
    $conn->close();
}
?>
