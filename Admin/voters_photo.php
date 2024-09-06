<?php
	include 'includes/session.php';

	if(isset($_POST['upload'])){
		$voter_id = $_POST['id'];  // Use `voter_id` as per the database schema
		$filename = $_FILES['photo']['name'];

		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}
		
		// Update the photo in the voters table
		$sql = "UPDATE voters SET photo = '$filename' WHERE voter_id = '$voter_id'";  // Ensure correct table and column names
		if($conn->query($sql)){
			$_SESSION['success'] = 'Photo updated successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Select voter to update photo first';
	}

	header('location: voters.php');
?>
