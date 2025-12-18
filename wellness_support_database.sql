-- Create the wellness support database
DROP DATABASE IF EXISTS wellness_support_database;
CREATE DATABASE wellness_support_database;
USE wellness_support_database;

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    firstName VARCHAR(50) NOT NULL, 
    lastName VARCHAR(50) NOT NULL,
    address VARCHAR(50) NOT NULL,
    city VARCHAR(50) NOT NULL,
    phone VARCHAR(20) NOT NULL,  
    email VARCHAR(100)  NOT NULL UNIQUE,  
    password VARCHAR(255) NOT NULL, 
    role ENUM('user', 'admin') DEFAULT 'user'
);

INSERT INTO users (firstName, lastName, address, city, phone, email, password, role) VALUES
('Bob', 'smith', '1730 huckleberry rd', 'Vancouver', '(301) 555-8950', 'bobsmith@gmail.com','magic5665', 'user'),
('Jeffrey', 'Smitzen', 'Post Office Box 924', 'Abbortsford', '91-12345-12345', 'jeffreys@example.com', 'magic5665', 'user'),
('Vance', 'Smith', '9 River Pk Pl E 400', 'Surrey', '(508) 555-8737', 'vsmith@example.com', 'magic5665', 'user'),
('Thom', 'Aaronsen', '7112 N Fresno St Ste 200', 'Vancouver', '(559) 555-8484', 'taaronsen@dgm.com', 'magic5665', 'user'),
('Harold', 'Spivak', '2874 S Cherry Ave', 'Burnaby', '(559) 555-2770', 'harold@propane.com', 'magic5665', 'user'),
('Rachael', 'Bluzinski', 'P.O. Box 860070', 'Langley', '(415) 555-7600', 'rachael@unocal.com', 'magic5665', 'user'),
('Reba', 'Hernandez', 'PO Box 2061', 'Vancouver', '(559) 555-0600', 'rhernandez@yesmed.com', 'magic5665', 'user'),
('Jaime', 'Ronaldsen', '3467 W Shaw Ave #103', 'Surrey', '(559) 555-8625', 'jronaldsen@zylka.com', 'magic5665', 'user'),
('Violet', 'Beauregard', 'P.O. Box 505820', 'Vancouver', '(800) 555-0855', 'vbeauregard@ups.com', 'magic5665', 'user'),
('Charlie', 'Bucket', 'Red Road', 'Surrey', '(800) 555-4091', 'cbucket@yahoo.com', 'magic5665', 'user');

CREATE TABLE services (
    service_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL, 
    description TEXT NOT NULL,
    category ENUM('yoga', 'meditation', 'sound_bath', 'reiki') NOT NULL,
    duration INT NOT NULL, -- in minutes
    price DECIMAL(6,2) NOT NULL
);

INSERT INTO services (title, description, category, duration, price) VALUES
('Sunrise Yoga', 'A gentle yoga flow to start your morning energized.', 'yoga', 60, 15.00),
('Mindful Meditation', 'A guided session to enhance focus and reduce stress.', 'meditation', 45, 10.00),
('Sound Bath Healing', 'Immerse yourself in healing vibrations.', 'sound_bath', 90, 25.00),
('Reiki Energy Balance', 'Restore your bodys energy with Reiki.', 'reiki', 60, 30.00);

CREATE TABLE teachers (
    teacher_id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL, 
    email VARCHAR(100) NOT NULL
);

INSERT INTO teachers (first_name, last_name, email) VALUES 
('Robert', 'Irwin', 'rirwin@gmail.com'), 
('Brittany', 'Louis', 'Blouis@gmail.com'), 
('Tiffany', 'Brown', 'tbrown@gmail.com'), 
('Brue', 'Duncan', 'bduncan@gmail.com'), 
('Jude', 'Red', 'jred@gmail.com'); 

CREATE TABLE sessions (
    session_id INT AUTO_INCREMENT PRIMARY KEY,
    service_id INT NOT NULL,
    teacher_id INT NOT NULL,
    session_datetime DATETIME NOT NULL,
    max_attendees INT NOT NULL,
    FOREIGN KEY (service_id) REFERENCES services(service_id),
    FOREIGN KEY (teacher_id) REFERENCES teachers(teacher_id)
);
INSERT INTO sessions (service_id, teacher_id, session_datetime, max_attendees) VALUES
(1, 1, '2025-05-01 07:00:00', 10),
(2, 2, '2025-05-01 09:00:00', 8),
(3, 3, '2025-05-02 18:30:00', 12),
(4, 4, '2025-05-03 11:00:00', 6);

CREATE TABLE bookings (
    booking_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    session_id INT NOT NULL,
    appointment_datetime DATETIME NOT NULL,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending' NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id), 
    FOREIGN KEY (service_id) REFERENCES services(service_id),
    FOREIGN KEY (session_id) REFERENCES sessions(session_id)
);

INSERT INTO bookings (user_id, service_id, session_id, appointment_datetime, status) VALUES
(1, 1, 1, '2025-05-01 07:00:00', 'confirmed'),
(2, 2, 2, '2025-05-01 09:00:00', 'pending'),
(3, 3, 3, '2025-05-02 18:30:00', 'confirmed'),
(4, 4, 4,  '2025-05-03 11:00:00', 'cancelled'),
(5, 1, 1, '2025-05-05 07:00:00', 'confirmed');


CREATE TABLE administrators (
  username    VARCHAR(40)    NOT NULL     UNIQUE,
  password    VARCHAR(40)    NOT NULL,
  PRIMARY KEY (username)
);

INSERT INTO administrators (username, password) VALUES
('admin', 'password');

