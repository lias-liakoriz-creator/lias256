<?php
	include 'includes/session.php';

	if(isset($_POST['edit'])){
		$voter_id = $_POST['voter_id'];  // Use `voter_id` as per the database schema
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$password = $_POST['password'];

		$sql = "SELECT * FROM voters WHERE voter_id = '$voter_id'";  // Query to select voter by voter_id
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		// Check if the new password is different from the existing one
		if(password_verify($password, $row['password'])){
			$password = $row['password'];  // If password is the same, keep it unchanged
		}
		else{
			$password = password_hash($password, PASSWORD_DEFAULT);  // Hash the new password
		}

		// Update the voter information in the voters table
		$sql = "UPDATE voters SET firstname = '$firstname', lastname = '$lastname', password = '$password' WHERE voter_id = '$voter_id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Voter updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Fill up edit form first';
	}

	header('location: voters.php');
?>
