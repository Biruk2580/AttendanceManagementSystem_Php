<?php
session_start();
$conn = new mysqli("localhost", "root", "", "attendance_system");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date = $_POST['date'];

    if (isset($_POST['attendance'])) {
        foreach ($_POST['attendance'] as $id => $status) {
            $status = $conn->real_escape_string($status);
            $sql = "INSERT INTO attendance (trainee_id, status, date) VALUES ('$id', '$status', '$date')";
            if (!$conn->query($sql)) {
                echo "Error: " . $conn->error;
            }
        }
    }

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
