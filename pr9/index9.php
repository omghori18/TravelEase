<!DOCTYPE html>
<html>
<head>
    <title>TravelEase Booking Form</title>
</head>
<body>
    <h2>Book Your Trip with TravelEase</h2>
    <form action="submit.php" method="POST">
        Full Name: <input type="text" name="name" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Destination: <input type="text" name="destination" required><br><br>
        Number of Travelers: <input type="number" name="travelers" required><br><br>
        Travel Date: <input type="date" name="travel_date" required><br><br>
        <input type="submit" value="Book Now">
    </form>
</body>
</html>
