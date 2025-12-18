<?php
require_once('../../config/database.php');
require_once('../models/user.php');
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../views/login/login.php");
    exit();
}

// DELETE
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'], $_GET['id']) && $_GET['action'] === 'delete') {
    try {
        deleteUser($db, $_GET['id']);
        header("Location: ../views/admin/manage_users.php?deleted=1");
        exit();
    } catch (Exception $e) {
        error_log("Delete error: " . $e->getMessage());
        header("Location: ../views/admin/manage_users.php?error=delete_failed");
        exit();
    }
}

// UPDATE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    try {
        updateUser($db, $_POST['user_id'], $_POST['firstName'], $_POST['lastName'], $_POST['address'], $_POST['city'], $_POST['phone'], $_POST['email']);
        header("Location: ../views/admin/manage_users.php?updated=1");
        exit();
    } catch (Exception $e) {
        error_log("Update error: " . $e->getMessage());
        header("Location: ../views/admin/manage_users.php?error=update_failed");
        exit();
    }
}

?>
