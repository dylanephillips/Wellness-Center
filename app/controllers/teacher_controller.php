<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../../config/database.php';
require_once '../models/service.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['admin_username'])) {
    // Get and sanitize input values
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    $errors = [];

    // Validate first_name: Should not be empty and should only contain letters and spaces
    if (empty($first_name)) {
        $errors[] = "First name is required.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $first_name)) {
        $errors[] = "First name should only contain letters and spaces.";
    }

    // Validate last_name: Should not be empty and should only contain letters and spaces
    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    } elseif (!preg_match("/^[a-zA-Z\s]+$/", $last_name)) {
        $errors[] = "Last name should only contain letters and spaces.";
    }

    // Validate email: Check if email is empty and if it's a valid format
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    // If there are validation errors, redirect with an error message
    if (!empty($errors)) {
        $error_message = implode(", ", $errors);
        header("Location: ../views/admin/create_teacher.php?error=" . urlencode($error_message));
        exit;
    }

    // If validation passes, attempt to create the teacher
    $teacherCreated = createTeacher($db, $first_name, $last_name, $email);

    if ($teacherCreated) {
        // Redirect to success page
        header("Location: ../views/admin/admin_menu.php?success=1");
        exit;
    } else {
        // If the insertion failed, redirect with an error
        header("Location: ../views/admin/create_teacher.php?error=Failed to create teacher");
        exit;
    }
} else {
    // If not a POST request or no admin session, redirect to login or error page
    header("Location: ../views/admin/login.php");
    exit;
}
?>
