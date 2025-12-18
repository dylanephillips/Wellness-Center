<?php
//Function to register a user. 
class User
{
    public static function register($pdo, $firstName, $lastName, $address, $city, $phone, $email, $password)
    {
        try {
            $stmt = $pdo->prepare("INSERT INTO users (firstName, lastName, address, city, phone, email, password, role)
                                   VALUES (:firstName, :lastName, :address, :city, :phone, :email, :password, 'user')");

            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}

// Function to get all users with role 'user'
function getAllUsers($db) {
    $stmt = $db->prepare("SELECT * FROM users WHERE role = 'user'");
    $stmt->execute();  
    return $stmt->fetchAll(PDO::FETCH_ASSOC);  
}

// Function to delete a user by user_id
function deleteUser($db, $user_id) {
    $stmt = $db->prepare("DELETE FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    return $stmt->execute();  // Executes the delete operation
}

// Function to update user details
function updateUser($db, $user_id, $firstName, $lastName, $address, $city, $phone, $email) {
    $stmt = $db->prepare("UPDATE users SET firstName = :firstName, lastName = :lastName, address = :address, city = :city, phone = :phone, email = :email WHERE user_id = :user_id");
    
    $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);
    $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
    $stmt->bindParam(':address', $address, PDO::PARAM_STR);
    $stmt->bindParam(':city', $city, PDO::PARAM_STR);
    $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    
    return $stmt->execute();  
}
?>


