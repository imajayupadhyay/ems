<?php
include "../includes/session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/dashboard.css" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <?php include "sidebar.php"; ?>

        <div class="main-content">
            <nav class="navbar navbar-dark bg-dark px-3">
                <a class="navbar-brand">Employee Dashboard</a>
            </nav>

            <div class="container mt-5 text-center">
                <h2>Welcome, <?= $_SESSION['employee_name']; ?>!</h2>
                <p>Use the sidebar to navigate.</p>
            </div>
        </div>
    </div>
</body>
</html>
