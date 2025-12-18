<?php
if (isset($_GET['success'])) {
    echo "<p class='success'>Service and session created successfully!</p>";
}
if (isset($_GET['error'])) {
    echo "<p class='error'>Error: " . htmlspecialchars($_GET['error']) . "</p>";
}
require_once('../../../config/database.php');

// Fetch teachers from DB
try {
    $stmt = $db->query("SELECT teacher_id, first_name, last_name FROM teachers");
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $teachers = [];
    echo "<p class='error'>Failed to load teachers: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Service</title>
    <link rel="stylesheet" type="text/css" href="../../../public/css/main.css"/>
</head>
<body>
    <header>
        <h1>Create New Service</h1>
        <a href="admin_menu.php">← Back to Admin Menu</a>
    </header>
     <!-- Create a service menu -->
    <main>
        <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="post" action="../../controllers/service_controller.php" class="create-service-form">
            <fieldset>
                <legend>Service Details</legend>
                <label>Title: <input type="text" name="title" required></label><br>
                <label>Description: <textarea name="description" required></textarea></label><br>
                <label>Category:
                    <select name="category" required>
                        <option value="yoga">Yoga</option>
                        <option value="meditation">Meditation</option>
                        <option value="sound_bath">Sound Bath</option>
                        <option value="reiki">Reiki</option>
                    </select>
                </label><br>
                <label>Duration (minutes): <input type="number" name="duration" min="15" required></label><br>
                <label>Price ($): <input type="number" step="0.01" name="price" min="0" required></label>
            </fieldset>

            <fieldset>
                <legend>Initial Session Details</legend>
                <label>Date and Time: <input type="datetime-local" name="session_datetime" required></label><br>
                <label>Max Attendees: <input type="number" name="max_attendees" min="1" required></label><br>
                <label>Teacher:
                    <select name="teacher_id" required>
                        <option value="">-- Select a Teacher --</option>
                        <?php foreach ($teachers as $teacher): ?>
                            <option value="<?= $teacher['teacher_id'] ?>">
                                <?= htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </fieldset>

            <button type="submit">Create Service & Session</button>
        </form>
    </main>
</body>
</html>
