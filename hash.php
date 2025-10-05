<?php
$plain_password = 'Admin@123';
$hash = password_hash($plain_password, PASSWORD_DEFAULT);
echo $hash;
?>
