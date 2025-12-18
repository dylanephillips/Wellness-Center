<?php
require_once('../../../config/database.php');
require_once('../../models/user.php');
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../login/login.php");
    exit();
}
// Fetch all users from the database
$users = getAllUsers($db);
$edit_id = $_GET['edit_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../../../public/css/main.css">
</head>
<body class="admin-body">

<h1 class="page-title">Manage Users</h1>
<a href="admin_menu.php" class="back-link">← Back to Admin Menu</a>
<!-- Display success messages -->
<?php if (isset($_GET['deleted'])): ?>
    <p class="success-msg">User deleted successfully.</p>
<?php elseif (isset($_GET['updated'])): ?>
    <p class="success-msg">User updated successfully.</p>
<?php endif; ?>
<!-- Users table -->
<table class="services-table">
    <thead>
        <tr>
            <th>First Name</th><th>Last Name</th><th>Address</th><th>City</th><th>Phone</th><th>Email</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($users as $user): ?>
        <?php if ($edit_id == $user['user_id']): ?>
            <!-- Edit form for a selected user -->
            <form method="POST" action="../../controllers/manage_user_controller.php">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
            <tr class="edit-row">
                <td><input class="input-field" name="firstName" value="<?= htmlspecialchars($user['firstName']) ?>"></td>
                <td><input class="input-field" name="lastName" value="<?= htmlspecialchars($user['lastName']) ?>"></td>
                <td><input class="input-field" name="address" value="<?= htmlspecialchars($user['address']) ?>"></td>
                <td><input class="input-field" name="city" value="<?= htmlspecialchars($user['city']) ?>"></td>
                <td><input class="input-field" name="phone" value="<?= htmlspecialchars($user['phone']) ?>"></td>
                <td><input class="input-field" name="email" value="<?= htmlspecialchars($user['email']) ?>"></td>
                <td>
                    <button class="btn save-btn" type="submit">Save</button>
                    <a class="btn cancel-btn" href="manage_users.php">Cancel</a>
                </td>
            </tr>
            </form>
        <?php else: ?>
             <!-- Display user info -->
            <tr>
                <td><?= htmlspecialchars($user['firstName']) ?></td>
                <td><?= htmlspecialchars($user['lastName']) ?></td>
                <td><?= htmlspecialchars($user['address']) ?></td>
                <td><?= htmlspecialchars($user['city']) ?></td>
                <td><?= htmlspecialchars($user['phone']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td>
                    <!-- Edit and Delete actions -->
                    <a class="action-link" href="manage_users.php?edit_id=<?= $user['user_id'] ?>">Edit</a> |
                    <a class="action-link delete" href="../../controllers/manage_user_controller.php?action=delete&id=<?= $user['user_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
