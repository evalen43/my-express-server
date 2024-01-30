<?php

$secret = 'ev1243$!'; // Replace with your generated secret token
$headerHash = $_SERVER['HTTP_X_HUB_SIGNATURE'];

// Get payload
$payload = file_get_contents('php://input');

// Calculate hash
$calculatedHash = 'sha1=' . hash_hmac('sha1', $payload, $secret, false);

// Verify hash
if (hash_equals($headerHash, $calculatedHash)) {
    // Execute command (e.g., git pull)
    exec('cd /home/evciztma/repositories/my-express-server && git pull');
    // Synchronize files
    exec('rsync -r --update --delete /home/evciztma/repositories/my-express-server/ /home/evciztma/public_html/');
    // Add more commands as needed
    echo 'Deployment triggered!';
} else {
    echo 'Invalid signature';
}
?>
