<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../../../config/database.php');
require_once('../../models/booking.php');
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../login/login.php");
    exit();
}
// Get all bookings function
$bookings = getAllBookings($db); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Bookings</title>
    <link rel="stylesheet" href="../../../public/css/main.css">
</head>
<body class="admin-body">
    <h1 class="page-title">Manage Bookings</h1>
    <a href="admin_menu.php" class="back-link">← Back to Admin Menu</a>

    <?php if (isset($_GET['deleted'])): ?>
        <p class="success-msg">Booking deleted successfully.</p>
    <?php elseif (isset($_GET['error'])): ?>
        <p class="error-msg">Error: <?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>
         <!-- Manage bookings table -->
    <table class="services-table">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>User ID</th>
                <th>Service ID</th>
                <th>Appointment</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= $booking['booking_id'] ?></td>
                    <td><?= $booking['firstName'] . ' ' . $booking['lastName'] ?></td>
                    <td><?= $booking['title'] ?></td>
                    <td><?= $booking['appointment_datetime'] ?></td>
                    <td><?= $booking['status'] ?></td>
                    <td>
                        <a class="action-link delete" href="../../controllers/booking_controller.php?action=delete&id=<?= $booking['booking_id'] ?>" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
