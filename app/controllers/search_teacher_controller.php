<?php
require_once('../../../config/database.php');
require_once('../../models/teacher_search.php');

session_start();

$teachers = [];

// Searches for teachers in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name']) ?? '';
    $last_name = trim($_POST['last_name']) ?? '';

    $teacherModel = new Teacher();
    $teachers = $teacherModel->searchTeachers($first_name, $last_name);
}
?>
