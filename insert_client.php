<?php
// Start the session
session_start();

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
                    $_SESSION["admin"] = $username; // Add this line to check if admin is logged in                            
                    
                    // Display success message
                    $message = "Login successful!";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                } else {
                    // Display an error message if password is not valid
                    $message = "The password you entered was not valid.";
                    echo "<script type='text/javascript'>alert('$message');</script>";
                }
            }
        } else {
            // Display an error message if username doesn't exist
            $message = "No account found with that username.";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    } else {
        $message = "Oops! Something went wrong. Please try again later.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }

    // Close statement
    $stmt->close();
}

if (isset($_POST['addClient'])) {
    // Prepare an insert statement
    $stmt = $conn->prepare("INSERT INTO clients (username, password) VALUES (?, ?)");

    // Bind variables to the prepared statement as parameters
    $stmt->bind_param("ss", $clientUsername, $hashedPassword);

    // Set parameters
    $clientId = $_POST['clientId'];
    $clientUsername = $_POST['clientUsername'];
    $hashedPassword = password_hash($_POST['clientPassword'], PASSWORD_DEFAULT); // Creates a password hash

    // Attempt to execute the prepared statement
    if ($stmt->execute()) {
        $message = "New client added successfully.";
        echo "<script type='text/javascript'>alert('$message');</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>