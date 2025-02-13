<?php
include "../includes/session.php";
include "../includes/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_SESSION['employee_id'];
    $task_description = $conn->real_escape_string($_POST['task_description']);

    $sql = "INSERT INTO tasks (employee_id, task_description) VALUES ('$employee_id', '$task_description')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Task added successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
