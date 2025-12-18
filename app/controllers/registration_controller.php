<?php
session_start();
require_once('../../config/database.php');
require_once('../models/user.php');

// Handles registration requests from users
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $address = trim($_POST['address']);
    $city = trim($_POST['city']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (User::register($db, $firstName, $lastName, $address, $city, $phone, $email, $password)) {
        header('Location: ../views/login/login.php?success=registration_success');
        exit();
    } else {
        header('Location: ../views/login/register.php?error=registration_failed');
        exit();
    }
} else {
    header('Location: ../views/login/register.php?error=invalid_request');
    exit();
}
?>
