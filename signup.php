<?php
session_start();
// Database connection code here
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stdntnum = $_POST['stdntnum'];
    $password = $_POST['password'];

    // Query the database to check credentials
    $sql = "SELECT * FROM Student WHERE StudentNumber = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $stdntnum);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['Password'])) {
            $_SESSION['user_id'] = $row['StudentNumber'];
            header("Location: CreateCard.html");
        } else {
            echo "Invalid password";
        }
    } else {
        echo "User not found";
    }
}
