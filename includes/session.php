<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['employee_id'])) {
    header("Location: ../employees/login.php");
    exit();
}
?>
