<?php
require_once('../../../config/database.php');
require_once('../../models/view_booking.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$bookingModel = new Booking();

// Handle Confirm or Cancel actions
if (isset($_GET['booking_id']) && isset($_GET['status'])) {
    $booking_id = $_GET['booking_id'];
    $status = $_GET['status'];

    // Only allow 'confirmed' or 'cancelled'
    if (in_array($status, ['confirmed', 'cancelled'])) {
        $bookingModel->updateBookingStatus($booking_id, $status);
    }

    // After updating, redirect back to the same page to avoid resubmission
    header("Location: view_booking.php");
    exit();
}

// Then load the bookings
$user_id = $_SESSION['user_id'];
$bookings = $bookingModel->getUserBookings($user_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Bookings</title>
    <link rel="stylesheet" href="../../../public/css/main.css">
</head>
<body>
    <header>
        <h1>Wellness Center</h1>
        <nav>
            <a href="user_dash.php" class="nav-link">Dashboard</a>
        </nav>
    </header>
     <!-- displaying the user's bookings -->
    <main>
        <section>
            <h2>Your Bookings</h2>
            <?php if (empty($bookings)): ?>
                <p>You have no bookings.</p>
            <?php else: ?>
                 <!-- Table displaying bookings -->
            <table class="services-table">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Appointment</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through each booking and display its details -->
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['service_title']); ?></td>
                            <td><?php echo htmlspecialchars($booking['appointment_datetime']); ?></td>
                            <td><?php echo ucfirst(htmlspecialchars($booking['status'])); ?></td>
                            <td>
                                <!-- Show Confirm or Cancel buttons if booking status is pending -->
                                <?php if ($booking['status'] === 'pending'): ?>
                                    <a href="view_booking.php?booking_id=<?php echo $booking['booking_id']; ?>&status=confirmed" class="button">Confirm</a>
                                    <a href="view_booking.php?booking_id=<?php echo $booking['booking_id']; ?>&status=cancelled" class="button">Cancel</a>
                                <?php else: ?>
                                    <span>-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Wellness Center</p>
    </footer>
</body>
</html>

