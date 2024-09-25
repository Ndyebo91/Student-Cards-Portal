<?php
// Database connection code here
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "PRTDatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stdntnum = $_POST['stdntnum'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        echo "Passwords do not match";
        exit;
    }

    // Check if student number exists
    $sql = "SELECT * FROM Students WHERE StudentNumber = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $stdntnum);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        echo "Student number not found";
        exit;
    }

    // Update password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
    $update_sql = "UPDATE Students SET Password = ? WHERE StudentNumber = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ss", $hashed_password, $stdntnum);

    if ($update_stmt->execute()) {
        echo "Password updated successfully";
    } else {
        echo "Error updating password";
    }
}
