<?php
require_once('../../../config/database.php');
require_once('../../controllers/search_teacher_controller.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Teachers</title>
    <link rel="stylesheet" href="../../../public/css/main.css">
</head>
<body>
    <header class="header">
        <h1 class="header-title">Wellness Center</h1>
        <nav class="nav">
            <a href="user_dash.php" class="nav-link">Dashboard</a>
        </nav>
    </header>
    <!-- Main content section for searching teachers -->
    <main class="main">
        <section class="search-section">
            <h2 class="search-title">Search for a Teacher</h2>
            <!-- Display search form if no POST request has been made or no teachers were found -->
            <?php if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($teachers)): ?>
                <form method="POST" action="search_teacher.php" class="search-form">
                    <label for="first_name" class="form-label">First Name:</label>
                    <input type="text" id="first_name" name="first_name" class="input-field" placeholder="Enter first name" required>

                    <label for="last_name" class="form-label">Last Name:</label>
                    <input type="text" id="last_name" name="last_name" class="input-field" placeholder="Enter last name" required>

                    <button type="submit" class="search-button">Search</button>
                </form>
            <?php else: ?>
                <!-- Display a new search link and the results table -->
                <a href="search_teacher.php" class="new-search-button">New Search</a>
                <table class="teacher-table">
                    <thead>
                        <tr>
                            <th class="table-header">First Name</th>
                            <th class="table-header">Last Name</th>
                            <th class="table-header">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Loop through the list of teachers and display each in a row -->
                        <?php foreach ($teachers as $teacher): ?>
                            <tr>
                                <td class="table-cell"><?php echo htmlspecialchars($teacher['first_name']); ?></td>
                                <td class="table-cell"><?php echo htmlspecialchars($teacher['last_name']); ?></td>
                                <td class="table-cell"><?php echo htmlspecialchars($teacher['email']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
             <!-- Display a message if no teachers are found -->
            <?php if (empty($teachers) && $_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                <p class="no-results">No teachers found matching your search.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date("Y"); ?> Wellness Center</p>
    </footer>
</body>
</html>


