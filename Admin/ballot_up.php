<?php
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];

		$output = array('error'=>false);

		// Select the position by its ID from the positions table
		$sql = "SELECT * FROM positions WHERE position_id='$id'";	
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		// Calculate the new priority by decreasing the current priority
		$priority = $row['priority'] - 1;

		// Check if the position is already at the top
		if($priority == 0){
			$output['error'] = true;
			$output['message'] = 'This position is already at the top';
		}
		else{
			// Update the position that currently has the new priority
			$sql = "UPDATE positions SET priority = priority + 1 WHERE priority = '$priority'";
			$conn->query($sql);

			// Update the selected position with the new priority
			$sql = "UPDATE positions SET priority = '$priority' WHERE position_id = '$id'";
			$conn->query($sql);
		}

		echo json_encode($output);

	}
?>
