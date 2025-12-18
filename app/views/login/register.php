<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="../../../public/css/main.css">
</head>
<body>
    <header>
        <h1>Wellness Center</h1>
        <p>Providing peace for your body and mind</p>
    </header>

    <main>
        <section class="register-section">
            <h2>Create Your Account</h2>

            <!-- Registration Form -->
            <form action="../../controllers/registration_controller.php" method="POST" class="form">
                <input type="hidden" name="action" value="register">
                <div class="form-group">
                    <label for="firstName">First Name:</label>
                    <input type="text" id="firstName" name="firstName" required>
                </div>

                <div class="form-group">
                    <label for="lastName">Last Name:</label>
                    <input type="text" id="lastName" name="lastName" required>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" required>
                </div>

                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <input type="submit" name="register" value="Register" class="button">
                </div>
            </form>

            <!-- Display error if any -->
            <?php
            if (!empty($_GET['error'])) {
                echo "<p class='error-message'>" . htmlspecialchars($_GET['error']) . "</p>";
            }
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Wellness Center</p>
    </footer>
</body>
</html>



