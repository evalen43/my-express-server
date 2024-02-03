<?php
// Start output buffering
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Start the session
session_start();

// Hiding the database credentials
require_once '/home/evciztma/db_config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the user's credentials from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

// Prepare the SQL statement
$stmt = $conn->prepare("SELECT `id`, password FROM clients WHERE username = ?");
    
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    // Bind parameters
    $result = $stmt->bind_param('s', $username);
    if ($result === false) {
        die("Error binding parameters: " . $stmt->error);
}
    
    $stmt->bind_param('s', $username);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
        //if ($password === $row['password']) {
            // The password is correct. Store the user's ID in the session
            $_SESSION['userid'] = $row['id'];
            
            // Store a success message in the session
            $_SESSION['message'] = 'Login successful! <br> <a href="https://evci-taxes4u.com/#customer-portal">Go to Customer Portal</a>';
            echo "Login successful!";

            // Redirect to upload.php
            header('Location: upload.php');
            exit;
        } else {
            // The password is incorrect
            echo "Invalid username or password.";
            header('Refresh: 5; URL=index.html'); // Redirect to the login page after 5 seconds
            exit;
        }
    } else {
        // The username does not exist
        echo "Invalid username or password.";
        header('Refresh: 5; URL=index.html'); // Redirect to the login page after 5 seconds
        exit;
    }

    // End output buffering and send output to the browser
    ob_end_flush();
    
}
?>