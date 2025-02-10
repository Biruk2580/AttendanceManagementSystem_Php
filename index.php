
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <!-- Include your CSS here -->
</head>
<body>
    <div class="sidebar">
        
		<div class="sidebar">
        <h2>Admin Panel</h2>
        <a href="javascript:void(0);" onclick="loadPage('dashboard')">Dashboard</a>
        <a href="javascript:void(0);" onclick="loadPage('register_trainee')">Register Trainees</a>
        <a href="javascript:void(0);" onclick="loadPage('attendance_form')">Mark Attendance</a>
        <a href="javascript:void(0);" onclick="loadPage('attendance_report')">Attendance Report</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>

    

        

    </div>
		<!-- Sidebar content -->
    </div>

    <div class="main-content" id="content">
        <!-- Initial content can go here, like the dashboard -->
    </div>

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
</html>--