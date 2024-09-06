<?php
    // Create a connection to the votlink_db database
    $conn = new mysqli('localhost', 'root', '', 'votlinkapp_db');

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>
