<?php
require_once('../../config/database.php');
require_once('../models/service.php');
session_start();

// Fetch teachers from DB
try {
    $stmt = $db->query("SELECT teacher_id, first_name, last_name FROM teachers");
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $teachers = [];
    echo "<p class='error'>Failed to load teachers: " . htmlspecialchars($e->getMessage()) . "</p>";
}

// Redirect if not admin
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../views/login/login.php");
    exit();
}

// Handle DELETE request (via GET)
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id']) && isset($_SESSION['admin_username'])) {
    try {
        deleteService($db, $_GET['id']);
        header("Location: ../views/admin/manage_services.php?deleted=1");
        exit();
    } catch (Exception $e) {
        header("Location: ../views/admin/manage_services.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

// Handle UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    try {
        $service_id = $_POST['service_id'];
        $session_id = $_POST['session_id'];
        $title = $_POST['title'];
        $category = $_POST['category'];
        $description = $_POST['description'];
        $duration = (int) $_POST['duration'];
        $price = (float) $_POST['price'];
        $session_datetime = $_POST['session_datetime'];
        $max_attendees = (int) $_POST['max_attendees'];
        $teacher_id = $_POST['teacher_id'];
        

        updateService($db, $service_id, $title, $category, $description, $duration, $price);
        updateSession($db, $session_id, $service_id, $teacher_id, $session_datetime, $max_attendees);

        header("Location: ../views/admin/manage_services.php?updated=1");
        exit();
    } catch (Exception $e) {
        header("Location: ../views/admin/manage_services.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}

// Fallback
header("Location: ../views/admin/manage_services.php?error=Invalid+request");
exit();
?>