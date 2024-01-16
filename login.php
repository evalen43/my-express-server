<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the user's credentials from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Initialize the SQLite database
    $db = new SQLite3('evci_tax_database.db');

    // Prepare the SQL statement
    $stmt = $db->prepare("SELECT id, password FROM users WHERE username = :username");
    $stmt->bindValue(':username', $username);

    // Execute the statement
    $result = $stmt->execute();

    if ($result) {
        $row = $result->fetchArray(SQLITE3_ASSOC);
        if ($row && password_verify($password, $row['password'])) {
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
}
?>