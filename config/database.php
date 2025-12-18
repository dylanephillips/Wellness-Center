<?php
    // Connects to the database to retrieve all the information
    $dsn = 'mysql:host=localhost;dbname=wellness_support_database';
    $username = '';
    $password = '';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('../config/wellness_support_error.php');
        exit();
    }
?>
