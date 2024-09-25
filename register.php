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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $studentNumber = $_POST['stdntnum'];
    $studentName = $_POST['name'];
    $studentSurname = $_POST['surname'];
    $yearOfStudy = $_POST['yos'];
    $department = $_POST['dept'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password (for security/privacy reasons)

    // Prepare SQL statement
    $sql = "INSERT INTO Student (StudentNumber, StudentName, StudentSurname, YearOfStudy, Department, Password) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind parameters to the prepared statement
    $stmt->bind_param("ssssss", $studentNumber, $studentName, $studentSurname, $yearOfStudy, $department, $password);

    // Execute the prepared statement
    if ($stmt->execute()) {
        // Redirect to success page(leads user back to Signup.html to log in)
        header("Location: registration_success.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
