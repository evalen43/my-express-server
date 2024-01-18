<?php
// Start output buffering
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Start the session
session_start();

// Database connection parameters
$db_host = 'ggehicom.ipagemysql.com';
$db_user = 'ggehicom';
$db_password = 'Evalen1243$';
$db_name = 'ecvci_taxes';

// Create a new database connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name);

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
        // if (password_verify($password, $row['password'])) {
        if ($password === $row['password']) {
            // The password is correct. Store the user's ID in the session
            $_SESSION['userid'] = $row['id'];
        
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