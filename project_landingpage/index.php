<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $message = sanitizeInput($_POST["message"]);

    // Basic input validation
    if (empty($name) || empty($email) || empty($message)) {
        die("Please fill out all the fields.");
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Database connection details
    $host = "localhost"; // Change if necessary
    $username = "root"; // Replace with your MySQL username
    $password = ""; // Replace with your MySQL password
    $database = "productlandingpage"; // Replace with your database name

    // Create a new connection
    $conn = new mysqli($host, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query to insert data into the database
    $stmt = $conn->prepare("INSERT INTO `productlandingpage`.`form_submissions` (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "<p>Form submitted successfully!</p>";
    } else {
        echo "<p>Error submitting form: " . $stmt->error . "</p>";
    }

    // Close the connection and statement
    $stmt->close();
    $conn->close();
}

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
