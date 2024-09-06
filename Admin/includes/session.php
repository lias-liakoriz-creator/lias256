<?php
	session_start();
	include 'includes/conn.php';

	// Check if the admin is logged in
	if(!isset($_SESSION['admin']) || trim($_SESSION['admin']) == ''){
		header('location: index.php');
		exit();
	}

	// Query to get the admin's data from the 'admins' table
	$sql = "SELECT * FROM admins WHERE admin_id = '".$_SESSION['admin']."'";
	$query = $conn->query($sql);
	$user = $query->fetch_assoc();
?>
