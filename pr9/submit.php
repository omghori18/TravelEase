<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and sanitize input
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $destination = htmlspecialchars(trim($_POST['destination']));
    $travelers = htmlspecialchars(trim($_POST['travelers']));
    $travel_date = htmlspecialchars(trim($_POST['travel_date']));

    // Define file paths (absolute paths)
    $folder = __DIR__;
    $csvFile = $folder . '/bookings.csv';
    $jsonFile = $folder . '/bookings.json';

    // -----------------------------
    // Store in CSV
    // -----------------------------
    $csvData = [$name, $email, $destination, $travelers, $travel_date];
    $fp = fopen($csvFile, 'a'); // Open in append mode
    if ($fp) {
        fputcsv($fp, $csvData);
        fclose($fp);
    } else {
        echo "<p style='color:red'>Error: Could not write to CSV file.</p>";
    }

    // -----------------------------
    // Store in JSON
    // -----------------------------
    $bookings = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : [];
    if (!is_array($bookings)) $bookings = []; // Ensure it's an array
    $bookings[] = [
        'name' => $name,
        'email' => $email,
        'destination' => $destination,
        'travelers' => $travelers,
        'date' => $travel_date
    ];

    if (file_put_contents($jsonFile, json_encode($bookings, JSON_PRETTY_PRINT)) === false) {
        echo "<p style='color:red'>Error: Could not write to JSON file.</p>";
    }

    // -----------------------------
    // Confirmation message
    // -----------------------------
    echo "<h3>Thank you, $name! Your booking for $destination has been recorded.</h3>";
    echo "<p><a href='index.php'>Back to Booking Form</a></p>";

} else {
    echo "<h3>Invalid request.</h3>";
}
?>
