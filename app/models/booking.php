<?php
// Function to get all bookings
function getAllBookings($db) {
    $query = "
        SELECT b.booking_id, u.firstName, u.lastName, s.title, b.appointment_datetime, b.status
        FROM bookings b
        JOIN users u ON b.user_id = u.user_id
        JOIN services s ON b.service_id = s.service_id
        ORDER BY b.appointment_datetime;
    ";
    $stmt = $db->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to delete bookings
function deleteBooking($db, $booking_id) {
    $stmt = $db->prepare("DELETE FROM bookings WHERE booking_id = ?");
    return $stmt->execute([$booking_id]);
}
?>
