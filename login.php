<?php
session_start();
include "db_connect.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $enteredCaptcha = $_POST['captchaInput'] ?? '';
    $hiddenCaptcha = $_POST['captcha_hidden'] ?? '';

    if (strcasecmp($enteredCaptcha, $hiddenCaptcha) !== 0) {
        echo "<script>alert('❌ Invalid Captcha! Please try again.'); window.history.back();</script>";
        exit;
    }

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, fullname, password FROM admins WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows === 1){
        $stmt->bind_result($admins_id, $admins_name, $admins_password);
        $stmt->fetch();
        if(password_verify($password, $admins_password)){
            $_SESSION['admin_id'] = $admins_id;
            $_SESSION['admin_name'] = $admins_name;
            header("Location: admin_dashboard.php");
            exit;
        } else {
            echo "<script>alert('Incorrect password for admin.'); window.history.back();</script>";
            exit;
        }
    }
    $stmt->close();

    $stmt = $conn->prepare("SELECT id, fullname, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows === 1){
        $stmt->bind_result($user_id, $user_name, $user_password);
        $stmt->fetch();
        if(password_verify($password, $user_password)){
            $_SESSION['user_id'] = $user_id;
            $_SESSION['fullname'] = $user_name;
            header("Location: dashboard.php");
            exit;
        } else {
            echo "<script>alert('Incorrect password for user.'); window.history.back();</script>";
            exit;
        }
    }
    $stmt->close();

    echo "<script>alert('User not found!'); window.history.back();</script>";
}
?>
