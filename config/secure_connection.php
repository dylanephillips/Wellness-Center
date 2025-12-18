<?php
// Ensure the page uses a secure connection
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];
    $url = "https://$host$uri";
    header("Location: $url");
    exit();
}
?>

