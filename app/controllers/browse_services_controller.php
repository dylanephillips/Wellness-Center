<?php
require_once('../../../config/database.php');
require_once('../models/view_booking.php');
session_start();

// Redirect if user not logged in
if (!isset($_SESSION['user_username'])) {
    header("Location: ../login/login.php");
    exit();
}

// Create Booking object
$booking = new Booking();

// Fetch available sessions
$services = $booking->getAvailableSessions();

// Pass the data to the view
require_once('../views/user/register_booking.php');


?>

