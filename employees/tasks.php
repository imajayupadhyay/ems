<?php
include "../includes/session.php";
include "../includes/config.php";

$employee_id = $_SESSION['employee_id'];
$task_query = "SELECT * FROM tasks WHERE employee_id = '$employee_id' ORDER BY created_at DESC";
$task_result = $conn->query($task_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tasks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/tasks.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <?php include "sidebar.php"; ?>
        
        <div class="main-content">
            <h2 class="navbar navbar-dark bg-dark px-3 text-white text-center mb-5">Your Tasks</h2>
            <form method="POST" action="add_task.php">
                <textarea name="task_description" class="form-control" placeholder="Enter task description..." required></textarea>
                <button type="submit" class="btn btn-primary w-100 mt-2">Add Task</button>
            </form>

            <ul class="list-group mt-3">
                <?php while ($task = $task_result->fetch_assoc()) { ?>
                    <li class="list-group-item mb-2">
                        <strong><?= date("M d", strtotime($task['task_date'])); ?>:</strong> 
                        <?= $task['task_description']; ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</body>
</html>
