<?php
include "../includes/session.php";
include "../includes/config.php";

$employee_id = $_SESSION['employee_id'];
$date = date("Y-m-d");

// Check if the employee has already punched in today
$query = "SELECT * FROM attendance WHERE employee_id = '$employee_id' AND DATE(punch_in) = '$date'";
$result = $conn->query($query);
$attendance = $result->fetch_assoc();

$punch_in_time = $attendance ? strtotime($attendance['punch_in']) : null;
$punch_out_time = $attendance['punch_out'] ? strtotime($attendance['punch_out']) : null;

$time_elapsed = 0;
if ($punch_in_time && !$punch_out_time) {
    $time_elapsed = time() - $punch_in_time; // Calculate elapsed time in seconds
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Punch In/Out</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/punch.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <?php include "sidebar.php"; ?>

        <div class="main-content text-center">
            <h2 class="navbar navbar-dark bg-dark px-3 text-white text-center mb-5">Punch In/Out</h2>
            <p class="text-muted">Your work duration will be tracked here.</p>

            <div class="clock-container">
                <h3 class="current-time" id="currentTime">00:00:00</h3>
            </div>

            <div class="timer-container">
                <h4>Work Duration</h4>
                <h3 id="workDuration">00:00:00</h3>
            </div>

            <form method="POST" action="attendance_action.php">
                <?php if (!$attendance) { ?>
                    <button type="submit" name="punch_in" class="btn btn-success w-50 mt-3">Punch In</button>
                <?php } elseif (!$attendance['punch_out']) { ?>
                    <button type="submit" name="punch_out" class="btn btn-warning w-50 mt-3">Punch Out</button>
                <?php } else { ?>
                    <button class="btn btn-secondary w-50 mt-3" disabled>Shift Completed</button>
                <?php } ?>
            </form>
        </div>
    </div>

    <script>
        // Live Clock
        function updateClock() {
            const now = new Date();
            document.getElementById('currentTime').innerText = now.toLocaleTimeString();
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Work Timer
        let startTime = <?= $time_elapsed ? $time_elapsed : 0 ?>;
        let isRunning = <?= ($punch_in_time && !$punch_out_time) ? 'true' : 'false' ?>;
        
        function updateTimer() {
            if (isRunning) {
                startTime++;
                let hours = Math.floor(startTime / 3600);
                let minutes = Math.floor((startTime % 3600) / 60);
                let seconds = startTime % 60;
                document.getElementById('workDuration').innerText =
                    String(hours).padStart(2, '0') + ":" +
                    String(minutes).padStart(2, '0') + ":" +
                    String(seconds).padStart(2, '0');
            }
        }
        setInterval(updateTimer, 1000);
    </script>
</body>
</html>
