<?php
session_start();
// Use PDO connection
require_once('../../config/database.php'); // Ensure this defines $db
require_once('../models/user.php');

//Authentication for Admin
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($role === 'admin') {
        $username = $_POST['username'] ?? '';

        $stmt = $db->prepare("SELECT * FROM administrators WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && $password === $admin['password']) {
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['role'] = 'admin';
            header("Location: ../views/admin/admin_menu.php");
            exit;
        } else {
            header("Location: ../views/login/login.php?error=Invalid admin credentials");
            exit;
        }
    
    // Authentication for User
    } elseif ($role === 'user') {
        $email = $_POST['email'] ?? '';

        $stmt = $db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $password === $user['password']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['firstName'] . ' ' . $user['lastName'];
            $_SESSION['role'] = 'user';
            header("Location: ../views/user/user_dash.php");
            exit;
        } else {
            header("Location: ../views/login/login.php?error=Invalid user credentials");
            exit;
        }

    } else {
        header("Location: ../views/login/login.php?error=Invalid role");
        exit;
    }
} else {
    header("Location: ../views/login/login.php?error=Invalid request method");
    exit;
}
?>
