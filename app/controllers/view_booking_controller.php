<?php
require_once('../models/view_booking.php');
require_once('../models/service.php');

class BookingController {
    private $bookingModel;

    public function __construct() {
        $this->bookingModel = new Booking();
    }

    // View all bookings for a user
    public function viewBookings($user_id) {
        $bookings = $this->bookingModel->getUserBookings($user_id);
    
        // Check the fetched bookings before passing to view
        error_log('Fetched bookings: ' . print_r($bookings, true));
    
        require_once('../views/user/view_booking.php');
    }

    // Fetch bookings without rendering view
    public function getBookings($user_id) {
        return $this->bookingModel->getUserBookings($user_id);
    }

    
    // Update booking status (confirm or cancel)
    public function updateBooking($booking_id, $status) {
        $this->bookingModel->updateBookingStatus($booking_id, $status);
        header("Location: view_booking.php");
        exit();
    }

    // Display available sessions for registration
    public function getAllServicesWithSessions($user_id) {
        $sessions = $this->bookingModel->getAvailableSessions();
        require_once('../views/user/register_booking.php');
    }

    // Register for a session
    public function registerForSession($user_id, $session_id) {
        $this->bookingModel->registerForSession($user_id, $session_id);
        header("Location: view_bookings.php"); // Redirect to view bookings page
        exit();
    }
}
?>
