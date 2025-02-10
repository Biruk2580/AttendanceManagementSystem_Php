<?php
$conn = new mysqli("localhost", "root", "", "attendance_system");

$result = $conn->query("
    SELECT attendees.name, attendance.date, attendance.status
    FROM attendance
    JOIN attendees ON attendees.id = attendance.attendee_id
    ORDER BY attendance.date, attendees.name
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Report</title>
</head>
<body>
    <h2>Attendance Report</h2>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
