<?php
	include 'includes/conn.php';
	session_start();

	if(isset($_SESSION['voter'])){
		// Ensure the voter ID is correctly referenced from the session
		$sql = "SELECT * FROM voters WHERE voter_id = '".$_SESSION['voter']."'";
		$query = $conn->query($sql);

		// Check if the query was successful
		if($query) {
			$voter = $query->fetch_assoc();
		} else {
			// Output error details
			echo "Error: " . $conn->error;
			exit();
		}
	}
	else{
		header('location: index.php');
		exit();
	}
?>
