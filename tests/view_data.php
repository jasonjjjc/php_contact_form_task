<?php
// Create a new database connection
$dbname = 'inc/contact_form.db';
$conn = new SQLite3($dbname);

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . $conn->lastErrorMsg());
}

// Prepare SQL statement to retrieve the data
$table = 'contact_form';
$query = "SELECT * FROM $table";

// Execute the query
$result = $conn->query($query);

// Check if the query was successful
if ($result) {
    // Display the data in a table
    echo "<table>
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Subject</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>";

    // Loop through the rows and display the data
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['first_name'] . "</td>";
        echo "<td>" . $row['last_name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['telephone'] . "</td>";
        echo "<td>" . $row['subject'] . "</td>";
        echo "<td>" . $row['message'] . "</td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
} else {
    echo "Error occurred while retrieving data from the database.";
}

// Close the database connection
$conn->close();
?>
