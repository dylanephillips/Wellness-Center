<?php
class Teacher {
    //Functon to search for a teacher by first and last name
    public function searchTeachers($first_name, $last_name) {
        global $db;
        $query = "
            SELECT teacher_id, first_name, last_name, email 
            FROM teachers 
            WHERE first_name LIKE :first_name 
              AND last_name LIKE :last_name
        ";
        $stmt = $db->prepare($query);

        $first_name = '%' . $first_name . '%';
        $last_name = '%' . $last_name . '%';

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
