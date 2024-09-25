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

if (isset($_POST['studentNumber'])) {
    $studentNumber = $_POST['studentNumber'];

    // Prepare SQL statement
    $sql = "SELECT * FROM Student WHERE StudentNumber = ?";

    // Create a prepared statement (let's go!!, we learned this in JAVA) 
    $stmt = $conn->prepare($sql);

    // Bind parameters to the prepared statement
    $stmt->bind_param("s", $studentNumber);

    // Execute the prepared statement
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<h3>Student Information:</h3>";
        echo "Name: " . $row['StudentName'] . " " . $row['StudentSurname'] . "<br>";
        echo "Student Number: " . $row['StudentNumber'] . "<br>";
        echo "Year of Study: " . $row['YearOfStudy'] . "<br>";
        echo "Department: " . $row['Department'] . "<br>";

        //Add logic to determine the status of the student card
        echo "<h3>Student Card Status:</h3>";
        echo "Your student card is ready for collection."; //A placeholder.Add a status field in database. Still have to finish this.
    } else {
        echo "No student found with the given student number.";
    }

    // Close statement
    $stmt->close();
} else {
    echo "Please provide a student number.";
}

// Close connection
$conn->close();
