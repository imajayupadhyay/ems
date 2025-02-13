<?php
include "../includes/session.php";
include "../includes/config.php";

$employee_id = $_SESSION['employee_id'];
$date = date("Y-m-d");

// Handle Punch In
if (isset($_POST['punch_in'])) {
    $punch_in_time = date("Y-m-d H:i:s");

    // Check if already punched in today
    $check_query = "SELECT * FROM attendance WHERE employee_id = '$employee_id' AND DATE(punch_in) = '$date'";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows == 0) {
        $sql = "INSERT INTO attendance (employee_id, punch_in) VALUES ('$employee_id', '$punch_in_time')";
        $conn->query($sql);
        echo "<script>alert('Punch In Successful!'); window.location.href='punch.php';</script>";
    } else {
        echo "<script>alert('You have already punched in today!'); window.location.href='punch.php';</script>";
    }
}

// Handle Punch Out
if (isset($_POST['punch_out'])) {
    $punch_out_time = date("Y-m-d H:i:s");

    // Check if already punched out
    $check_query = "SELECT * FROM attendance WHERE employee_id = '$employee_id' AND DATE(punch_in) = '$date' AND punch_out IS NULL";
    $check_result = $conn->query($check_query);

    if ($check_result->num_rows > 0) {
        $sql = "UPDATE attendance SET punch_out = '$punch_out_time', 
                work_hours = TIMESTAMPDIFF(SECOND, punch_in, '$punch_out_time') / 3600
                WHERE employee_id = '$employee_id' AND DATE(punch_in) = '$date'";
        $conn->query($sql);
        echo "<script>alert('Punch Out Successful!'); window.location.href='punch.php';</script>";
    } else {
        echo "<script>alert('You have not punched in today or already punched out!'); window.location.href='punch.php';</script>";
    }
}
?>
