<?php
// Create a new database connection
$dbname = 'inc/contact_form.db';
$conn = new SQLite3($dbname);

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . $conn->lastErrorMsg());
}

// Prepare SQL statement to create a table if it doesn't exist
$table = 'contact_form';
$query = "CREATE TABLE IF NOT EXISTS $table (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            first_name TEXT NOT NULL,
            last_name TEXT NOT NULL,
            email TEXT NOT NULL,
            telephone TEXT NOT NULL,
            subject TEXT NOT NULL,
            message TEXT NOT NULL
        )";

// Execute the query to create the table
$result = $conn->exec($query);

// Check if the table creation was successful
if (!$result) {
    die("Table creation failed: " . $conn->lastErrorMsg());
}

// Validate and sanitize the form data
$firstName = sanitizeInput($_POST["first-name"]);
$lastName = sanitizeInput($_POST["last-name"]);
$email = sanitizeInput($_POST["email"]);
$telephone = sanitizeInput($_POST["telephone"]);
$subject = sanitizeInput($_POST["subject"]);
$message = sanitizeInput($_POST["message"]);

// Perform server-side validation
$errors = [];

// Validate email format using regex
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

// Check telephone number length
if (strlen($telephone) > 11) {
    $errors[] = "Telephone number should not exceed 11 characters";
}

if (!empty($errors)) {
    $response = [
        'success' => false,
        'errors' => $errors
    ];
    echo json_encode($response);
} else {
    // Save data to the database
    $stmt = $conn->prepare("INSERT INTO $table (first_name, last_name, email, telephone, subject, message) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $firstName);
    $stmt->bindParam(2, $lastName);
    $stmt->bindParam(3, $email);
    $stmt->bindParam(4, $telephone);
    $stmt->bindParam(5, $subject);
    $stmt->bindParam(6, $message);

    $result = $stmt->execute();

    // Check if the data insertion was successful
    if ($result) {
        $response = [
            'success' => true
        ];
        echo json_encode($response);
    } else {
        $response = [
            'success' => false,
            'errors' => ["Error occurred while saving the form data."]
        ];
        echo json_encode($response);
    }
}

// Close the database connection
$conn->close();

function sanitizeInput($input) {
    return trim(strip_tags($input));
}
