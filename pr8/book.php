<?php
include 'db1.php';

if (isset($_POST['book'])) {
    $user_id  = $_POST['user_id'];
    $event_id = $_POST['event_id'];

    $sql = "INSERT INTO bookings (user_id, event_id, booking_date) VALUES ('$user_id','$event_id',NOW())";
    if ($conn->query($sql) === TRUE) {
        echo "Booking confirmed!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<form method="post">
  <input type="number" name="user_id" placeholder="User ID" required><br>
  <input type="number" name="event_id" placeholder="Event ID" required><br>
  <button type="submit" name="book">Book Now</button>
</form>
