<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "PRTDatabase";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form data is received
if (isset($_POST['stdntnum']) && isset($_POST['password'])) {
    $studentNumber = $_POST['stdntnum'];
    $password = $_POST['password'];

    // Prepare SQL statement
    $sql = "SELECT * FROM Student WHERE StudentNumber = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters to the prepared statement
    $stmt->bind_param("s", $studentNumber);

    // Execute the prepared statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Student number exists, now check password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['Password'])) {
            echo "success";
        } else {
            echo "Incorrect password. Please try again.";
        }
    } else {
        echo "Student number not found. Please check and try again.";
    }

    // Close statement
    $stmt->close();
} else {
    echo "Invalid request. Please try again.";
}

// Close connection
$conn->close();
