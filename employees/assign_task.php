<?php
include "../includes/session.php";
include "../includes/config.php";

// Fetch all employees except the logged-in user
$employee_id = $_SESSION['employee_id'];
$employees_query = "SELECT id, first_name, last_name FROM employees WHERE id != '$employee_id'";
$employees_result = $conn->query($employees_query);

// Handle Task Assignment
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $assigned_to = $_POST['assigned_to'];
    $task_description = $conn->real_escape_string($_POST['task_description']);

    $sql = "INSERT INTO assigned_tasks (assigned_by, assigned_to, task_description)
            VALUES ('$employee_id', '$assigned_to', '$task_description')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Task Assigned Successfully!'); window.location.href='assign_task.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assign Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/tasks.css" rel="stylesheet">
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
        <nav class="navbar px-3 mb-3">
                <a class="navbar-brand">Assign a Task</a>
            </nav>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Select Employee</label>
                    <select name="assigned_to" class="form-control" required>
                        <?php while ($row = $employees_result->fetch_assoc()) { ?>
                            <option value="<?= $row['id'] ?>"><?= $row['first_name'] . " " . $row['last_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Task Description</label>
                    <textarea name="task_description" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-30">Assign Task</button>
            </form>
        </div>
    </div>
</body>
</html>
