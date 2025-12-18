<?php
require_once('../../config/database.php');
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../views/user/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['session_id'])) {
    // Retrieve session_id and user_id from POST request and session
    $session_id = (int) $_POST['session_id'];
    $user_id = $_SESSION['user_id'];

    try {
        // Get the service_id and session_datetime from the sessions table
        $stmt = $db->prepare("SELECT service_id, session_datetime FROM sessions WHERE session_id = :session_id");
        $stmt->bindParam(':session_id', $session_id, PDO::PARAM_INT);
        $stmt->execute();
        $session = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($session) {
            //  Insert the booking into the bookings table
            $insert = $db->prepare("INSERT INTO bookings (user_id, service_id, session_id, appointment_datetime, status) 
                                    VALUES (:user_id, :service_id, :session_id, :appointment_datetime, 'pending')");
            $insert->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $insert->bindParam(':service_id', $session['service_id'], PDO::PARAM_INT);
            $insert->bindParam(':session_id', $session_id, PDO::PARAM_INT);
            $insert->bindParam(':appointment_datetime', $session['session_datetime']);
            $insert->execute();

            // Redirect with success
            header("Location: ../views/user/register_booking.php?registered=1");
            exit();
        } else {
            // No session found
            header("Location: ../views/user/register_booking.php?error=Session+not+found");
            exit();
        }
    } catch (Exception $e) {
        // Log and handle exceptions gracefully
        error_log($e->getMessage()); // This will log the error to the server's log
        header("Location: ../views/user/register_booking.php?error=" . urlencode("An error occurred. Please try again."));
        exit();
    }
} else {
    // Invalid request if session_id is not provided
    header("Location: ../views/user/register_booking.php?error=Invalid+request");
    exit();
}
?>



