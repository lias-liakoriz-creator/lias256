<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];

		// Adjusted SQL query to delete a candidate using 'candidate_id'
		$sql = "DELETE FROM candidates WHERE candidate_id = '$id'";

		if($conn->query($sql)){
			$_SESSION['success'] = 'Candidate deleted successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: candidates.php');
?>
