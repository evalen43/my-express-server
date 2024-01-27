<?php
// Start the session
session_start();

// Database connection parameters
/* $db_host = 'localhost';
$db_user = 'ernesto';
$db_password = 'Evalen1243$';
$db_name = 'evciztma_evci_taxes';

// Create a new database connection
$conn = new mysqli($db_host, $db_user, $db_password, $db_name); */

// Hiding the database credentials
require_once '/home/evciztma/db_config.php';

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['adminLogin'])) {
    // Prepare a select statement
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");

    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("s", $username);

    // Set parameters
    $username = $_POST['username'];

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        // Store result
        $stmt->store_result();

        // Check if username exists, if yes then verify password
        if ($stmt->num_rows == 1) {                    
            // Bind result variables
            $stmt->bind_result($id, $username, $hashed_password);
            if ($stmt->fetch()) {
                if (password_verify($_POST['password'], $hashed_password)) {
                    // Password is correct, so start a new session
                    session_start();
                    
                    // Store data in session variables
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username;                            
                    
                    // Redirect user to welcome page
                    header("location: welcome.php");
                } else {
                    // Display an error message if password is not valid
                    echo "The password you entered was not valid.";
                }
            }
        } else {
            // Display an error message if username doesn't exist
            echo "No account found with that username.";
        }
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }

    // Close statement
    $stmt->close();
}

if (isset($_POST['addClient'])) {
    // Prepare an insert statement
    $stmt = $conn->prepare("INSERT INTO clients (id, username, password) VALUES (?, ?, ?)");

    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("iss", $clientId, $clientUsername, $hashedPassword);

    // Set parameters
    $clientId = $_POST['clientId'];
    $clientUsername = $_POST['clientUsername'];
    $hashedPassword = password_hash($_POST['clientPassword'], PASSWORD_DEFAULT); // Creates a password hash

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        echo "New client added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>