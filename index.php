<!DOCTYPE html>
<html>
<head>
    <title>Contact Form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Contact Form</h1>
    <div class="form-container">
        <?php
        // Display success message
        if (isset($_GET['success'])) {
            echo "<div class='success'>Form submitted successfully!</div>";
        }

        // Display error message
        if (isset($_GET['error'])) {
            echo "<div class='error'>Error occurred while submitting the form.</div>";
        }
        ?>

        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="first-name">First Name:</label>
            <input type="text" name="first-name" required>
            <br>
            <label for="last-name">Last Name:</label>
            <input type="text" name="last-name" required>
            <br>
            <label for="email">Email Address:</label>
            <input type="email" name="email" required>
            <br>
            <label for="telephone">Telephone Number:</label>
            <input type="tel" name="telephone" required maxlength="11">
            <br>
            <label for="subject">Subject:</label>
            <select name="subject" required>
                <option value="">Select...</option>
                <option value="Enquiry">Enquiry</option>
                <option value="Call Back">Call Back</option>
                <option value="Complaint">Complaint</option>
            </select>
            <br>
            <label for="message">Message:</label>
            <textarea name="message" required></textarea>
            <br>
            <input type="submit" value="Submit">
        </form>

        <?php
        // Form handling and database operations
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate and sanitize the form data
            $firstName = $_POST["first-name"];
            $lastName = $_POST["last-name"];
            $email = $_POST["email"];
            $telephone = $_POST["telephone"];
            $subject = $_POST["subject"];
            $message = $_POST["message"];

            // Perform server-side validation
            $isValid = true;
            $errors = [];

            // Validate email format using regex
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $isValid = false;
                $errors[] = "Invalid email format";
            }

            // Check telephone number length
            if (strlen($telephone) > 11) {
                $isValid = false;
                $errors[] = "Telephone number should not exceed 11 characters";
            }

            // If validation fails, display error messages
            if (!$isValid) {
                echo "<div class='error'>Error(s) occurred:</div>";
                foreach ($errors as $error) {
                    echo "<div class='error'>$error</div>";
                }
            } else {
                // Save data to the database
                $conn = new SQLite3('inc/contact_form.db');

                if (!$conn) {
                    die("Connection failed: " . $conn->lastErrorMsg());
                }

                $table = 'contact_form';
                $stmt = $conn->prepare("INSERT INTO $table (first_name, last_name, email, telephone, subject, message) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bindParam(1, $firstName);
                $stmt->bindParam(2, $lastName);
                $stmt->bindParam(3, $email);
                $stmt->bindParam(4, $telephone);
                $stmt->bindParam(5, $subject);
                $stmt->bindParam(6, $message);

                $result = $stmt->execute();

                if ($result) {
                    // Redirect with success message
                    header("Location: index.php?success=true");
                    exit;
                } else {
                    // Redirect with error message
                    header("Location: index.php?error=true");
                    exit;
                }
            }
        }
        ?>
    </div>
</body>
</html>
