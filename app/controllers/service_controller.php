<?php
require_once('../../config/database.php');
require_once('../models/service.php');
session_start();

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

// Handle CREATE request (via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['admin_username'])) {
    try {
        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $category = $_POST['category'] ?? '';
        $duration = $_POST['duration'] ?? 0;
        $price = $_POST['price'] ?? 0;
        $session_datetime = $_POST['session_datetime'] ?? '';
        $max_attendees = $_POST['max_attendees'] ?? 0;
        $teacher_id = $_POST['teacher_id'] ?? 0;

        $service_id = createService($db, $title, $description, $category, $duration, $price);
        createSession($db, $service_id, $teacher_id, $session_datetime, $max_attendees);

        header("Location: ../views/admin/admin_menu.php?success=1");
    } catch (Exception $e) {
        header("Location: ../views/admin/create_service.php?error=" . urlencode($e->getMessage()));
    }
}

// Handles Update for services
if ($_POST['action'] === 'update') {
    $service_id = $_POST['service_id'];
    $session_id = $_POST['session_id'];
    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $duration = $_POST['duration'];
    $price = $_POST['price'];
    $datetime = $_POST['session_datetime'];
    $max_attendees = $_POST['max_attendees'];
    $teacher_id = $_POST['teacher_id'];

    updateService($db, $service_id, $title, $category, $description, $duration, $price);
    updateSession($db, $session_id, $service_id, $teacher_id, $datetime, $max_attendees);

    header("Location: ../views/admin/manage_services.php");
    exit();
}

// Make sure user is logged in
if (!isset($_SESSION['admin_username'])) {
    header("Location: ../views/login/login.php");
    exit();
}
// a fallback error message for unsupported operations
header("Location: ../views/admin/admin_menu.php?error=Unsupported+request");
exit();

?>
