<?php
include "../includes/session.php";
include "../includes/config.php";

$employee_id = $_SESSION['employee_id'];
$current_month = date('Y-m');

// Fetch attendance count for this month
$attendance_query = "SELECT COUNT(*) AS total_attendance FROM attendance 
                     WHERE employee_id = '$employee_id' AND DATE_FORMAT(punch_in, '%Y-%m') = '$current_month'";
$attendance_result = $conn->query($attendance_query);
$attendance = $attendance_result->fetch_assoc()['total_attendance'] ?? 0;

// Fetch total assigned tasks
$tasks_query = "SELECT COUNT(*) AS total_tasks FROM assigned_tasks 
                WHERE assigned_to = '$employee_id'";
$tasks_result = $conn->query($tasks_query);
$tasks = $tasks_result->fetch_assoc()['total_tasks'] ?? 0;

// Fetch total working hours this month
$work_hours_query = "SELECT SUM(work_hours) AS total_hours FROM attendance 
                     WHERE employee_id = '$employee_id' AND DATE_FORMAT(punch_in, '%Y-%m') = '$current_month'";
$work_hours_result = $conn->query($work_hours_query);
$total_hours = $work_hours_result->fetch_assoc()['total_hours'] ?? 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/dashboard.css" rel="stylesheet">
    <style>
     .navbar{
    background-color:#05386b;
   margin:0px;
   border-radius:25px;
}
.navbar-brand{
    color:white;
    font-size:bold;
}
    </style>
</head>
<body>
    <div class="wrapper">
        <?php include "sidebar.php"; ?>

        <div class="main-content">
        <nav class="navbar px-3">
                <a class="navbar-brand">Employee Dashboard</a>
                <h4 class="text-white">Welcome, <?= $_SESSION['employee_name']; ?>!</h4>
            </nav>

            <div class="container mt-4">
                <!-- Dashboard Summary -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card summary-card">
                            <h5>Total Attendance</h5>
                            <h3><?= $attendance ?></h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card summary-card">
                            <h5>Assigned Tasks</h5>
                            <h3><?= $tasks ?></h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card summary-card">
                            <h5>Total Work Hours</h5>
                            <h3><?= round($total_hours, 2) ?> hrs</h3>
                        </div>
                    </div>
                </div>

                <!-- Attendance & Tasks Chart -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card chart-card">
                            <h5>Attendance Overview</h5>
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card chart-card">
                            <h5>Task Progress</h5>
                            <canvas id="taskChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../assets/js/charts.js"></script>

    <script>
        loadAttendanceChart(<?= $attendance ?>);
        loadTaskChart(<?= $tasks ?>);
    </script>
</body>
</html>


