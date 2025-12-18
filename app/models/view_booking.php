<?php

class Booking {
    // Fetch all bookings for a user
    public function getUserBookings($user_id) {
        global $db;
        $stmt = $db->prepare("
            SELECT b.booking_id, b.appointment_datetime, b.status, s.title AS service_title, ses.session_datetime
            FROM bookings b
            JOIN services s ON b.service_id = s.service_id
            JOIN sessions ses ON b.session_id = ses.session_id
            WHERE b.user_id = :user_id
              AND b.status != 'cancelled'
        ");
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // Add a new booking
    public function addBooking($user_id, $service_id, $appointment_datetime) {
        global $db;
        $stmt = $db->prepare("
            INSERT INTO bookings (user_id, service_id, appointment_datetime, status)
            VALUES (:user_id, :service_id, :appointment_datetime, 'pending')
        ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':service_id', $service_id);
        $stmt->bindParam(':appointment_datetime', $appointment_datetime);
        return $stmt->execute();
    }

    // Update booking status (confirm or cancel)
    public function updateBookingStatus($booking_id, $status) {
        global $db;
        $stmt = $db->prepare("
            UPDATE bookings SET status = :status WHERE booking_id = :booking_id
        ");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':booking_id', $booking_id);
        return $stmt->execute();
    }

    // Fetch all available sessions
    public function getAvailableSessions() {
        global $db;
        $stmt = $db->prepare("
            SELECT 
                s.session_id, 
                s.session_datetime, 
                s.max_attendees, 
                se.title, 
                se.category, 
                se.description, 
                se.duration, 
                se.price, 
                t.first_name, 
                t.last_name
            FROM sessions s
            JOIN services se ON s.service_id = se.service_id
            JOIN teachers t ON s.teacher_id = t.teacher_id
            ORDER BY s.session_datetime ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    // Function to create a booking
    function createBooking($db, $user_id, $session_id) {
        $stmt = $db->prepare("INSERT INTO bookings (user_id, service_id, appointment_datetime, status) 
                          SELECT :user_id, service_id, session_datetime, 'pending'
                          FROM sessions
                          WHERE session_id = :session_id");
    
        return $stmt->execute([
            ':user_id' => $user_id,
            ':session_id' => $session_id
        ]);
    }

    // Register a user for a session
    public function registerForSession($user_id, $session_id) {
        global $db;
        $stmt = $db->prepare("
            INSERT INTO bookings (user_id, session_id, appointment_datetime, status)
            SELECT :user_id, s.session_id, s.session_datetime, 'pending' 
            FROM sessions s
            WHERE s.session_id = :session_id AND (SELECT COUNT(*) FROM bookings b WHERE b.session_id = s.session_id) < s.max_attendees
        ");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':session_id', $session_id);
        return $stmt->execute();
    }
}
?>

