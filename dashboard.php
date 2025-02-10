<?php
session_start();
$conn = new mysqli("localhost", "root", "", "attendance_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['trainee_name'])) {
    $trainee_name = $conn->real_escape_string($_POST['trainee_name']);

    if (!empty($trainee_name)) {
        $sql = "INSERT INTO attendees (name) VALUES ('$trainee_name')";
        if ($conn->query($sql) === TRUE) {
            echo "New trainee registered successfully!";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Please enter a trainee name.";
    }
}

// Fetch statistics
$totalTraineesResult = $conn->query("SELECT COUNT(*) AS total FROM attendees");
$totalTrainees = $totalTraineesResult->fetch_assoc()['total'];

$totalAttendanceResult = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE status='Present'");
$totalAttendance = $totalAttendanceResult->fetch_assoc()['total'];

$totalAbsencesResult = $conn->query("SELECT COUNT(*) AS total FROM attendance WHERE status='Absent'");
$totalAbsences = $totalAbsencesResult->fetch_assoc()['total'];

$presentPercentage = $totalTrainees > 0 ? round(($totalAttendance / ($totalTrainees * 5)) * 100, 2) : 0; // Assuming 5 days of training
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { display: flex; height: 100vh; }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: fixed; /* Fixed sidebar */
            height: 100%;
        }
        .sidebar a {
            text-decoration: none;
            color: white;
            padding: 10px;
            margin: 5px 0;
            display: block;
            width: 100%;
            text-align: center;
            background: #34495e;
            border-radius: 5px;
            cursor: pointer;
        }
        .sidebar a:hover { background: #1abc9c; }

        /* Main content */
        .main-content {
            flex: 1;
            padding: 20px;
            margin-left: 250px; /* Space for sidebar */
            background: #ecf0f1;
            height: 100%;
            overflow-y: auto;
        }
        .cards {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            width: calc(50% - 20px); /* Responsive width */
            margin: 10px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }
        .card h3 { color: #333; }
        .card p { font-size: 20px; font-weight: bold; }

        /* Form Styling */
        .form-container {
            margin-top: 20px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            display: flex; /* Use flex for form alignment */
            flex-direction: column; /* Stack form elements */
            align-items: center; /* Center align */
        }
        .form-container input {
            padding: 10px;
            width: 80%; /* Make the input wider */
            margin-bottom: 10px; /* Space between input and button */
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            padding: 10px 20px;
            background: #1abc9c;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
        }
        .form-container button:hover {
            background: #16a085;
        }

        /* Logout */
        .logout { margin-top: auto; background: red; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="javascript:void(0);" onclick="loadPage('home')">Dashboard</a>
        <a href="javascript:void(0);" onclick="loadPage('register_trainee')">Register Trainees</a>
        <a href="javascript:void(0);" onclick="loadPage('attendance_form')">Mark Attendance</a>
        <a href="javascript:void(0);" onclick="loadPage('attendance_report')">Attendance Report</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="content">
        <h1>Dashboard</h1>
<div class="cards">
    <div class="card">
        <h3>Total Trainees</h3>
        <p><?php echo $totalTrainees; ?></p>
    </div>
    <div class="card">
        <h3>Present</h3>
        <p><?php echo $totalAttendance; ?></p>
    </div>
    <div class="card">
        <h3>Absent</h3>
        <p><?php echo $totalAbsences; ?></p>
    </div>
    <div class="card">
        <h3>Present Percentage</h3>
        <p><?php echo $presentPercentage; ?>%</p>
    </div>
</div>

<!-- Register Trainee Form -->

            </div>
        </div>

        <!-- Register Trainee Form -->
        

    </div>

    <!-- JavaScript to Handle AJAX Requests and Page Load -->
    <script>
        function loadPage(page) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", page + ".php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("content").innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>

</body>
</html>