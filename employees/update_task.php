<?php
include "../includes/session.php";
include "../includes/config.php";

if (!isset($_GET['task_id'])) {
    die("Task ID is missing!");
}

$task_id = $_GET['task_id'];
$employee_id = $_SESSION['employee_id'];

// Fetch task details
$task_query = "SELECT * FROM assigned_tasks WHERE id = '$task_id' AND assigned_to = '$employee_id'";
$task_result = $conn->query($task_query);

if ($task_result->num_rows == 0) {
    die("Task not found or you are not authorized to update this task.");
}

$task = $task_result->fetch_assoc();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = $_POST['status'];
    $issue = $conn->real_escape_string($_POST['issue']);

    $update_query = "UPDATE assigned_tasks 
                     SET status = '$status', issue = '$issue', updated_at = NOW() 
                     WHERE id = '$task_id'";

    if ($conn->query($update_query) === TRUE) {
        echo "<script>alert('Task Updated Successfully!'); window.location.href='assigned_tasks.php';</script>";
    } else {
        echo "Error updating task: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Task</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/tasks.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <?php include "sidebar.php"; ?>

        <div class="main-content">
            <h2 class="text-center mt-3">Update Task</h2>

            <form method="POST" class="task-form">
                <div class="mb-3">
                    <label class="form-label">Task Description</label>
                    <textarea class="form-control" disabled><?= $task['task_description'] ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Update Status</label>
                    <select name="status" class="form-control" required>
                        <option value="Pending" <?= $task['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="Processing" <?= $task['status'] == 'Processing' ? 'selected' : '' ?>>Processing</option>
                        <option value="Completed" <?= $task['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                        <option value="Rejected" <?= $task['status'] == 'Rejected' ? 'selected' : '' ?>>Rejected</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mention Any Issue (Optional)</label>
                    <textarea name="issue" class="form-control"><?= $task['issue'] ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Update Task</button>
            </form>
        </div>
    </div>
</body>
</html>
