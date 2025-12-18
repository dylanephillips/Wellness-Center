<?php
require_once('../../../config/database.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_name = $_SESSION['name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../../../public/css/main.css"/>
</head>
<body>
    <header>
        <h1>Wellness Center</h1>
        <p>User Dashboard</p>
        <nav>
            <a href="../../views/login/login.php" class="nav-link">Home</a>
        </nav>
    </header>

    <main>
         <!-- Display the user dashboard with links-->
        <section class="menu-section">
            <h2>User Menu</h2>
            <ul class="admin-menu">
                <li><a href="../../views/user/register_booking.php" class="menu-item">Register for Booking</a></li>
                <li><a href="../../views/user/search_teacher.php" class="menu-item">Search for Teacher</a></li>
                <li><a href="../../views/user/view_booking.php" class="menu-item">View Bookings</a></li>
            </ul>
            
            <div class="login-status">
                <p>You are logged in as <strong><?php echo htmlspecialchars($user_name); ?></strong></p>
                <form action="../../views/login/logout.php" method="post">
                    <input type="submit" class="logout-button" value="Logout">
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Wellness Center</p>
    </footer>
</body>
</html>


