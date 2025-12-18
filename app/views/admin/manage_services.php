<?php
require_once('../../../config/database.php');
require_once('../../models/service.php');
session_start();

if (!isset($_SESSION['admin_username'])) {
    header("Location: ../login/login.php");
    exit();
}
// Fetch all services along with their session details
$services = getAllServicesWithSessions($db);
$edit_id = $_GET['edit_id'] ?? null;

$categories = ['Yoga', 'Meditation', 'Reiki', 'Sound Healing'];
// Fetch all teachers for the dropdown
$teachers = getAllTeachers($db); 
$raw_datetime = $service['session_datetime'];
$datetime_value = '';

if ($timestamp = strtotime($raw_datetime)) {
    $datetime_value = date('Y-m-d\TH:i', $timestamp);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Services</title>
    <link rel="stylesheet" href="../../../public/css/main.css">
</head>
<body class="admin-body">

<h1 class="page-title">Manage Services</h1>
<a href="admin_menu.php" class="back-link">← Back to Admin Menu</a>
<!-- Display success or error messages -->
<?php if (isset($_GET['deleted'])): ?>
    <p class="success-msg">Service deleted successfully.</p>
<?php elseif (isset($_GET['error'])): ?>
    <p class="error-msg">Error: <?= htmlspecialchars($_GET['error']) ?></p>
<?php endif; ?>

<table class="services-table">
    <thead>
        <tr>
            <th>Title</th><th>Category</th><th>Description</th><th>Duration</th><th>Price</th>
            <th>Session Time</th><th>Max Attendees</th><th>Teacher</th><th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($services as $service): ?>
        <?php if ($edit_id == $service['service_id']): ?>
            <!-- Edit mode for selected service -->
            <form method="POST" action="../../controllers/manager_service_controller.php">
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="service_id" value="<?= $service['service_id'] ?>">
            <input type="hidden" name="session_id" value="<?= $service['session_id'] ?>">
            <tr class="edit-row">
                <td><input class="input-field" name="title" value="<?= htmlspecialchars($service['title']) ?>"></td>
                <td>
                    <select class="input-field" name="category">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat ?>" <?= ($service['category'] === $cat) ? 'selected' : '' ?>>
                                <?= $cat ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td><input class="input-field" name="description" value="<?= htmlspecialchars($service['description']) ?>"></td>
                <td><input class="input-field" name="duration" type="number" value="<?= htmlspecialchars($service['duration']) ?>"></td>
                <td><input class="input-field" name="price" type="number" value="<?= htmlspecialchars($service['price']) ?>"></td>
                <td><input class="input-field" name="session_datetime" type="datetime-local" value="<?= date('Y-m-d\TH:i', strtotime($service['session_datetime'])) ?>"></td>
                <td><input class="input-field" name="max_attendees" type="number" value="<?= htmlspecialchars($service['max_attendees']) ?>"></td>
                <td>
                    <select class="input-field" name="teacher_id" required>
                        <option value="">Select a Teacher</option>
                        <?php foreach ($teachers as $teacher): ?>
                            <option value="<?= $teacher['teacher_id'] ?>" <?= $teacher['teacher_id'] == $service['teacher_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <button class="btn save-btn" type="submit">Save</button>
                    <a class="btn cancel-btn" href="manage_services.php">Cancel</a>
                </td>
            </tr>
            </form>
        <?php else: ?>
            <!-- Display service in view mode -->
            <tr>
                <td><?= htmlspecialchars($service['title']) ?></td>
                <td><?= htmlspecialchars($service['category']) ?></td>
                <td><?= htmlspecialchars($service['description']) ?></td>
                <td><?= $service['duration'] ?> mins</td>
                <td>$<?= $service['price'] ?></td>
                <td><?= htmlspecialchars($service['session_datetime']) ?></td>
                <td><?= $service['max_attendees'] ?></td>
                <td><?= htmlspecialchars($service['first_name'] . ' ' . $service['last_name']) ?></td>
                <td>
                    <a class="action-link" href="manage_services.php?edit_id=<?= $service['service_id'] ?>">Edit</a> |
                    <a class="action-link delete" href="../../controllers/service_controller.php?action=delete&id=<?= $service['service_id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>

