<?php
// Start a session
session_start();
$conn = new mysqli("localhost", "root", "", "attendance_system");

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the selected date
    $date = $_POST['date'];

    // Loop through the attendance data and insert into the database
    if (isset($_POST['attendance'])) {
        foreach ($_POST['attendance'] as $id => $status) {
            $status = $conn->real_escape_string($status);
            $sql = "INSERT INTO attendance (trainee_id, status, date) VALUES ('$id', '$status', '$date')";
            if (!$conn->query($sql)) {
                // Error message if insert fails
                echo "Error: " . $conn->error;
            }
        }
    }

    // Redirect to the dashboard page after submitting the attendance
    //header("Location: dashboard.php");
    //exit();  // Ensure no further code is executed
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
</head>
<body>
    <h2>Mark Attendance for Training</h2>
    <form action="mark_attendance.php" method="post">
        <label>Select Date:</label>
        <input type="date" name="date" required><br><br>

        <table border="1">
            <tr>
                <th>Name</th>
                <th>Present</th>
                <th>Absent</th>
            </tr>
            <?php
            // Fetch the list of attendees from the database
            $result = $conn->query("SELECT * FROM attendees");
            while ($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td>
                        <input type="radio" name="attendance[<?php echo $row['id']; ?>]" value="Present" required>
                    </td>
                    <td>
                        <input type="radio" name="attendance[<?php echo $row['id']; ?>]" value="Absent">
                    </td>
                </tr>
            <?php } ?>
        </table>
        <br>
        <button type="submit">Submit Attendance</button>
    </form>
</body>
</html>
