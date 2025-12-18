<?php
require_once('../../../config/database.php');
require_once('../../models/service.php');
session_start();
if (isset($_GET['success'])) {
    echo "<p class='success'>Service and session created successfully!</p>";
}
if (isset($_GET['error'])) {
    echo "<p class='error'>Error: " . htmlspecialchars($_GET['error']) . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create a Teacher</title>
    <link rel="stylesheet" type="text/css" href="../../../public/css/main.css"/>
</head>
<body>
    <header>
        <h1>Create New Teacher</h1>
        <a href="admin_menu.php">← Back to Admin Menu</a>
    </header>
     <!-- Create a teacher form -->
    <main>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="post" action="../../controllers/teacher_controller.php" class="create-service-form">
            <fieldset>
                <legend>Teacher Details</legend>
                <label>First Name: <input type="text" name="first_name" required></label><br>
                <label>Last Name: <input type="text" name="last_name" required></label><br><br>
                <label>Email: <input type="email" name="email" required></label><br><br>
            </fieldset>
            <button type="submit">Create a teacher</button>
        </form>
    </main>
</body>
</html>