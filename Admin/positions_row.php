<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		// Adjust the column name from 'id' to 'position_id' to match the 'positions' table structure
		$sql = "SELECT * FROM positions WHERE position_id = '$id'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		// Return the row as a JSON object
		echo json_encode($row);
	}
?>
