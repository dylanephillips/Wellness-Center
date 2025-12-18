
<html>
    <head>
        <title>Log In</title>
        <link rel="stylesheet" type="text/css" href="../../../public/css/main.css"/>
    </head>
    <body onload="toggleFields()">
        <header>
            <h1>Wellness Center</h1>
            <p>Providing peace for your body and mind</p>
        </header>

        <main>
        <?php
        // If coming from successful registration
        if (!empty($_GET['success'])) {
            echo "<p style='color: green;'>Registration successful! You can now log in.</p>";
        }

        // If coming from a login error
        if (!empty($_GET['error'])) {
            $error = htmlspecialchars($_GET['error']);
            if ($error === "invalid_credentials") {
                echo "<p style='color: red;'>Invalid username or password. Please try again.</p>";
        } elseif ($error === "registration_failed") {
            echo "<p style='color: red;'>Registration failed. Please try again.</p>";
            }
        }
        ?>

            <form action="../../../app/controllers/auth_controller.php" method="POST">
                <!-- Role selection for Admin or User -->
                <div class="form-group">
                    <label for="role">Login as:</label>
                    <select name="role" id="role" onchange="toggleFields()">
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>

                <!-- Admin login fields--> 
                <div id="admin-fields" class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" required>
                </div>

                <!-- User login fields -->
                <div id="user-fields" class="form-group" style="display: none;">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <!-- Common password field -->
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <input type="submit" value="Log In">

                 <!-- Register button -->
                <div style="margin-top: 20px;" class="form-group">
                    <a href="register.php" class="button-secondary-button">Register</a>
                </div>
            </form>

            <!-- Display error message if any -->
            <?php
            if (!empty($_GET['error'])) {
                echo "<p style='color: red;'>".$_GET['error']."</p>";
            }
            ?>
        </main>

        <footer>
            <p>&copy; <?php echo date("Y"); ?> Wellness Center</p>
        </footer>

        <script>
            // Function to show/hide fields based on selected role
            function toggleFields() {
                var role = document.getElementById("role").value;
                var adminField = document.getElementById("admin-fields");
                var userField = document.getElementById("user-fields");
                var usernameInput = document.getElementById("username");
                var emailInput = document.getElementById("email");

                 // Toggle fields based on role
                if (role === "admin") {
                    adminField.style.display = "block";
                    userField.style.display = "none";
                    usernameInput.disabled = false;
                    emailInput.disabled = true;
                } else {
                    adminField.style.display = "none";
                    userField.style.display = "block";
                    usernameInput.disabled = true;
                    emailInput.disabled = false;
                }
            }
            // Automatically toggle fields when page loads
            window.onload = toggleFields;
        </script>
    </body>
</html>