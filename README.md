Database Connection Credentials:
Host: localhost
Database Name: wellness_support_database
Username: 
Password: (empty)

To access phpMyAdmin, use:
Username: 
Password: (empty)

Errors will occur if the database connection is not properly configured.
Ensure that your database.php file contains the following credentials:
$dsn = 'mysql:host=localhost;dbname=wellness_support_database;
$username = '';
$password = '';
If your MySQL configuration is different, update this file. 
Installation instructions 
Install XAMPP:
	•	Version Required: XAMPP 8.2.4 or compatible.
	•	Download from: https://www.apachefriends.org/index.html
Install PHP and MySQL:
	•	PHP Version: 8.2.4 or higher
	•	MySQL Version: 8.0 or compatible (included in XAMPP)

Overview
Welcome to the Wellness Center Web Application!
The Wellness Center Web Application allows users to register, log in, book services, and for administrators to manage services and users. It is developed using PHP (OOP and MVC structure), MySQL, HTML/CSS, and runs on a local server environment such as XAMPP.


User Roles and Functionalities
Administrator
	•	Login: Username and password authentication.
	•	Admin Menu: Access to manage system data.
	•	Functionalities:
	◦	Create Service: Add Services.
	◦	Create Teacher: Add Teachers.
	◦	Manage Bookings: View and update customer bookings.
	◦	Manage Users: Update and delete users
	◦	Manage Services: View and update services
	◦	Logout feature
User
	•	Login: Email and password authentication.
	•	Register for booking: Displays all available bookings and will allow you to register for them. .
	•	Search for Teacher: Allows the use of first name and last name to look up a teacher to view there information. 
	•	View booking: View all the bookings you have signed up for and confirm or cancel them. 
	•	Logout: Users can securely log out of the system.
	•	Register user: User can fill out form to create an account 

Contact Information
For any issues or troubleshooting, please contact the development team.
