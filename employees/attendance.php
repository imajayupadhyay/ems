<?php
include "../includes/session.php";
include "../includes/config.php";

$employee_id = $_SESSION['employee_id'];
$attendance_query = "SELECT * FROM attendance WHERE employee_id = '$employee_id' ORDER BY punch_in DESC";
$attendance_result = $conn->query($attendance_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Attendance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/attendance.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <?php include "sidebar.php"; ?>
        
        <div class="main-content">
            <h2 class="navbar navbar-dark bg-dark px-3 text-white text-center mb-5 ">Attendance History</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Punch In</th>
                        <th>Punch Out</th>
                        <th>Hours</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $attendance_result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= date("M d, Y", strtotime($row['punch_in'])); ?></td>
                            <td><?= date("H:i:s", strtotime($row['punch_in'])); ?></td>
                            <td><?= $row['punch_out'] ? date("H:i:s", strtotime($row['punch_out'])) : '—'; ?></td>
                            <td><?= $row['work_hours'] ? $row['work_hours'] . ' hrs' : '—'; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
