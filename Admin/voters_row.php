<?php 
	include 'includes/session.php';

	if(isset($_POST['id'])){
		$id = $_POST['id'];
		$sql = "SELECT * FROM voters WHERE voter_id = '$id'";
		$query = $conn->query($sql);

		if($query) {
			$row = $query->fetch_assoc();
			echo json_encode($row);
		} else {
			// Handle the error if the query fails
			echo json_encode(['error' => $conn->error]);
		}
	}
?>
