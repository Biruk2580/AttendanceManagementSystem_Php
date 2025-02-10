<?php
$conn = new mysqli("localhost", "root", "", "attendance_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];
    foreach ($_POST['attendance'] as $attendee_id => $status) {
        $sql = "INSERT INTO attendance (attendee_id, date, status) 
                VALUES ('$attendee_id', '$date', '$status')
                ON DUPLICATE KEY UPDATE status='$status'";
        $conn->query($sql);
    }
	header("Location: dashboard.php");
    exit(); 
    //echo "Attendance marked successfully!";
}
?>