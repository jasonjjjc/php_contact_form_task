<?php
// Create a new database connection
$conn = new SQLite3('inc/contact_form.db');

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . $conn->lastErrorMsg());
}

// Delete all data from the table
$table = 'contact_form';
$query = "DELETE FROM $table";

$result = $conn->exec($query);

// Check if the data deletion was successful
if ($result) {
    echo "Data cleared successfully!";
} else {
    echo "Error occurred while clearing the data.";
}

// Close the database connection
$conn->close();
?>
