<?php
session_start();

if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
    unset($_SESSION['message']);
}

if (!isset($_SESSION['userid'])) {
    // The user is not logged in
    echo "Please log in before uploading files.";
    exit;
}

$target_dir = "clients/";

// Array of allowed file types
$allowed_file_types = ['image/jpeg', 'image/png', 'application/pdf','text/plain'];

// Maximum file size in bytes (2MB in this example)
$max_file_size = 2 * 1024 * 1024;

// Loop over each file in the files array
for($i=0; $i<count($_FILES['fileToUpload']['name']); $i++) {
    $file_type = $_FILES["fileToUpload"]["type"][$i];
    $file_size = $_FILES["fileToUpload"]["size"][$i];

    if (!in_array($file_type, $allowed_file_types)) {
        echo "Received file type: " . $file_type . ". Allowed file types: JPG, PNG, PDF, and TXT.";
        exit;
    }

    if ($file_size > $max_file_size) {
        echo "Sorry, your file is too large. Maximum file size is 2MB.";
        exit;
    }

    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"][$i])). " has been uploaded.";
        $_SESSION['message'] = 'File uploaded successfully! <br> <a href="https://evci-taxes4u.com/#customer-portal">Go to Customer Portal</a>';
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>