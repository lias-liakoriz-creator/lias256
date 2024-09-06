<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT *, candidates.candidate_id AS canid FROM candidates 
				LEFT JOIN positions ON positions.position_id = candidates.position_id 
				WHERE candidates.candidate_id = '$id'";
		$query = $conn->query($sql);
		$row = $query->fetch_assoc();

		echo json_encode($row);
	}
?>
