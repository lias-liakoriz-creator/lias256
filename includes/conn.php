<?php
	$conn = new mysqli('localhost', 'root', '', 'votlinkapp_db');

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
?>
