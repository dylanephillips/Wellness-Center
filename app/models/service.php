<?php
// Function to create a service
function createService($db, $title, $description, $category, $duration, $price) {
    $stmt = $db->prepare("INSERT INTO services (title, description, category, duration, price)
                          VALUES (:title, :description, :category, :duration, :price)");
    $stmt->execute([
        ':title' => $title,
        ':description' => $description,
        ':category' => $category,
        ':duration' => $duration,
        ':price' => $price
    ]);
    return $db->lastInsertId();
}

// Function to create a session
function createSession($db, $service_id, $teacher_id, $datetime, $max_attendees) {
    $stmt = $db->prepare("INSERT INTO sessions (service_id, teacher_id, session_datetime, max_attendees)
                          VALUES (:service_id, :teacher_id, :session_datetime, :max_attendees)");
    return $stmt->execute([
        ':service_id' => $service_id,
        ':teacher_id' => $teacher_id,
        ':session_datetime' => $datetime,
        ':max_attendees' => $max_attendees
    ]);
}

//Function to get all services/sessions 
function getAllServicesWithSessions($db) {
    try {
        $stmt = $db->query("SELECT s.*, ss.session_id, ss.session_datetime, ss.max_attendees, ss.teacher_id, t.first_name, t.last_name
                            FROM services s
                            LEFT JOIN sessions ss ON s.service_id = ss.service_id
                            LEFT JOIN teachers t ON ss.teacher_id = t.teacher_id
                            WHERE ss.session_id IN (SELECT MAX(session_id) FROM sessions GROUP BY service_id)
                            ORDER BY s.service_id DESC");

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$results) {
            error_log("No services with sessions found.");
        }
        return $results;
    } catch (PDOException $e) {
        error_log("Error in getAllServicesWithSessions: " . $e->getMessage());
        return []; // Return empty array or false as fallback
    }
}

function deleteService($db, $service_id) {
    // Delete sessions associated with this service
    $stmt1 = $db->prepare("DELETE FROM sessions WHERE service_id = :service_id");
    $stmt1->execute([':service_id' => $service_id]);

    // Now delete the service itself
    $stmt2 = $db->prepare("DELETE FROM services WHERE service_id = :service_id");
    return $stmt2->execute([':service_id' => $service_id]);
}

// Function to update service details
function updateService($db, $service_id, $title, $category, $description, $duration, $price) {
    $stmt = $db->prepare("UPDATE services SET title = ?, category = ?, description = ?, duration = ?, price = ? WHERE service_id = ?");
    $stmt->bindValue(1, $title, PDO::PARAM_STR);
    $stmt->bindValue(2, $category, PDO::PARAM_STR);
    $stmt->bindValue(3, $description, PDO::PARAM_STR);
    $stmt->bindValue(4, $duration, PDO::PARAM_INT);
    $stmt->bindValue(5, $price, PDO::PARAM_STR); // use STR for decimals unless exact precision is needed
    $stmt->bindValue(6, $service_id, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        throw new Exception("Failed to update service: " . implode(" | ", $stmt->errorInfo()));
    }
    return true;
}

function updateSession($db, $session_id, $teacher_id, $session_datetime, $max_attendees) {
    // Try to parse the datetime
    $timestamp = strtotime($session_datetime);

    if ($timestamp === false) {
        // Invalid datetime 
        $session_datetime = date('Y-m-d H:i:s'); 
    } else {
        // Format to proper SQL datetime format
        $session_datetime = date('Y-m-d H:i:s', $timestamp);
    }
    $stmt = $db->prepare("UPDATE sessions SET teacher_id = ?, session_datetime = ?, max_attendees = ? WHERE session_id = ?");
    $stmt->bindValue(1, $teacher_id, PDO::PARAM_INT);
    $stmt->bindValue(2, $session_datetime, PDO::PARAM_STR); 
    $stmt->bindValue(3, $max_attendees, PDO::PARAM_INT);
    $stmt->bindValue(4, $session_id, PDO::PARAM_INT);

    if (!$stmt->execute()) {
        throw new Exception("Failed to update session: " . implode(" | ", $stmt->errorInfo()));
    }
    return true;
}

 function getServicesWithSessions($db) {
        try {
            // SQL query to fetch services with sessions
            $stmt = $db->query("SELECT s.service_id, s.title, s.category, s.description, s.duration, s.price,
                                        ss.session_id, ss.session_datetime, ss.max_attendees, 
                                        t.first_name, t.last_name
                                 FROM services s
                                 LEFT JOIN sessions ss ON s.service_id = ss.service_id
                                 LEFT JOIN teachers t ON ss.teacher_id = t.teacher_id
                                 WHERE ss.session_id IS NOT NULL
                                 ORDER BY s.service_id DESC");

            // Fetch all data and return it
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error fetching services with sessions: " . $e->getMessage());
            return []; // Return empty array if there's an error
        }
    }

// Function to get all teachers
function getAllTeachers($db) {
    $stmt = $db->prepare("SELECT teacher_id, first_name, last_name, email FROM teachers");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//Function to create a teacher
function createTeacher($db, $first_name, $last_name, $email) {
    $stmt = $db->prepare("INSERT INTO teachers (first_name, last_name, email) VALUES (?, ?, ?)");
    return $stmt->execute([$first_name, $last_name, $email]);
}
?>