<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$position = $_POST['position'];
		$party = $_POST['party'];  // Assuming the party field is included in the form
		$nickname = $_POST['nickname'];  // Assuming the nickname field is included in the form
		$filename = $_FILES['photo']['name'];
		
		// Handling file upload
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}

		// Insert candidate data into the candidates table
		$sql = "INSERT INTO candidates (position_id, firstname, lastname, nickname, candidate_name, party, photo) 
		        VALUES ('$position', '$firstname', '$lastname', '$nickname', CONCAT('$firstname', ' ', '$lastname'), '$party', '$filename')";
		
		if($conn->query($sql)){
			$_SESSION['success'] = 'Candidate added successfully';
		} else {
			$_SESSION['error'] = $conn->error;
		}
	} else {
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: candidates.php');
?>
