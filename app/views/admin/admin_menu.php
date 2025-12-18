<?php
require_once('../../../config/secure_connection.php');  // require a secure connection

session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: login.php");
    exit();
}
$admin_username = $_SESSION['admin_username']; // Get logged-in admin username
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Menu</title>
    <link rel="stylesheet" type="text/css" href="../../../public/css/main.css"/>
</head>
<body>
    <header>
        <h1>Wellness Center Admin</h1>
        <p>Admin Dashboard</p>
        <nav>
            <a href="../../views/login/login.php" class="nav-link">Home</a>
        </nav>
    </header>
    <!-- Admin menu -->
    <main>    
        <section class="menu-section">
            <h2>Admin Menu</h2>
            <ul class="admin-menu">
                <li><a href="create_service.php" class="menu-item">Create Service</a></li>
                <li><a href="create_teacher.php" class="menu-item">Create Teacher</a></li>
                <li><a href="manage_booking.php" class="menu-item">Manage Booking</a></li>
                <li><a href="manage_users.php" class="menu-item">Manage Users</a></li>
                <li><a href="manage_services.php" class="menu-item">Manage Services</a></li>
            </ul>

            <div class="login-status">
                <p>You are logged in as <strong><?php echo htmlspecialchars($admin_username); ?></strong></p>
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



