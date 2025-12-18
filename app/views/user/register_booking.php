<?php
require_once('../../../config/database.php');
require_once('../../models/view_booking.php');
// Create a new Booking object
$booking = new Booking();
// Fetch available sessions from the Booking model
$services = $booking->getAvailableSessions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Available Services</title>
    <link rel="stylesheet" href="../../../public/css/main.css">
</head>
<body class="user-body">

<h1 class="page-title">Available Sessions & Services</h1>
<a href="../user/user_dash.php" class="back-link">← Back to Menu</a>
<!-- Success and error messages -->
<?php if (isset($_GET['registered'])): ?>
    <p class="success-msg">Successfully registered for the session!</p>
<?php elseif (isset($_GET['error'])): ?>
    <p class="error-msg">Error: <?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>
<!-- Table displaying the available services -->
<table class="services-table">
    <thead>
        <tr>
            <th>Title</th><th>Category</th><th>Description</th><th>Duration</th><th>Price</th>
            <th>Session Date & Time</th><th>Teacher</th><th>Max Attendees</th><th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Check if there are any available services -->
    <?php if (!empty($services)): ?>
        <?php foreach ($services as $service): ?>
            <tr>
                <td><?= htmlspecialchars($service['title']) ?></td>
                <td><?= htmlspecialchars($service['category']) ?></td>
                <td><?= htmlspecialchars($service['description']) ?></td>
                <td><?= htmlspecialchars($service['duration']) ?> min</td>
                <td>$<?= htmlspecialchars(number_format($service['price'], 2)) ?></td>
                <td><?= date('M d, Y H:i', strtotime($service['session_datetime'])) ?></td>
                <td><?= htmlspecialchars($service['first_name'] . ' ' . $service['last_name']) ?></td>
                <td><?= htmlspecialchars($service['max_attendees']) ?></td>
                <td>
                     <!-- Form for registering for a session -->
                    <form method="POST" action="../../controllers/register_session_controller.php">
                        <input type="hidden" name="session_id" value="<?= $service['session_id'] ?>">
                        <button type="submit" class="action-button">Register</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="9">No available sessions at the moment.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>



