<?php
require_once('../../config/database.php');
require_once('../models/booking.php');

// Handles booking deletion: checks request, validates ID, deletes the booking, and redirects with success or error message.
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $booking_id = $_GET['id'] ?? null;

    if ($booking_id && is_numeric($booking_id)) {
        $success = deleteBooking($db, $booking_id);

        if ($success) {
            header("Location: ../views/admin/manage_booking.php?deleted=1");
            exit();
        } else {
            header("Location: ../views/admin/manage_booking.php?error=Could not delete booking.");
            exit();
        }
    } else {
        header("Location: ../views/admin/manage_booking.php?error=Invalid booking ID.");
        exit();
    }
} else {
    header("Location: ../views/admin/manage_booking.php");
    exit();
}
?>


