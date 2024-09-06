<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$voter_id = $_POST['id'];  // Use the appropriate column name from the voters table, i.e., voter_id
		$sql = "DELETE FROM voters WHERE voter_id = '$voter_id'";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Voter deleted successfully';
		}
		else{
			$_SESSION['error'] = $conn->error;
		}
	}
	else{
		$_SESSION['error'] = 'Select item to delete first';
	}

	header('location: voters.php');
?>
