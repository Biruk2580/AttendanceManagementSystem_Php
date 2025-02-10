<?php
session_start();
$conn = new mysqli("localhost", "root", "", "attendance_system");

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $trainee_name = $conn->real_escape_string($_POST['trainee_name']);

    if (!empty($trainee_name)) {
        $sql = "INSERT INTO attendees (name) VALUES ('$trainee_name')";
        if ($conn->query($sql) === TRUE) {
          
		  //echo "New trainee registered successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Please enter a trainee name.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Trainee</title>
</head>
<body>
    <h1>Register Trainee</h1>
    <form id="registerForm" method="POST">
        <label for="trainee_name">Trainee Name:</label>
        <input type="text" name="trainee_name" id="trainee_name" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
