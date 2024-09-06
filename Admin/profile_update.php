<?php
	include 'includes/session.php';

	// Check if 'return' parameter is set, else default to 'home.php'
	if(isset($_GET['return'])){
		$return = $_GET['return'];
	} else {
		$return = 'home.php';
	}

	// Check if 'save' form was submitted
	if(isset($_POST['save'])){
		$curr_password = $_POST['curr_password'];
		$username = $_POST['username'];
		$password = $_POST['password'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$photo = $_FILES['photo']['name'];

		// Verify current password against the stored hashed password
		if(password_verify($curr_password, $user['password'])){
			// Handle photo upload
			if(!empty($photo)){
				move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$photo);
				$filename = $photo;	
			} else {
				$filename = $user['photo'];
			}

			// If the new password is the same as the current one, keep it unchanged
			if($password == $user['password']){
				$password = $user['password'];
			} else {
				$password = password_hash($password, PASSWORD_DEFAULT);
			}

			// Update admin details in the database (use 'admin_id' instead of 'id')
			$sql = "UPDATE admins SET username = '$username', password = '$password', firstname = '$firstname', lastname = '$lastname', photo = '$filename' WHERE admin_id = '".$user['admin_id']."'";
			if($conn->query($sql)){
				$_SESSION['success'] = 'Admin profile updated successfully';
			} else {
				$_SESSION['error'] = $conn->error;
			}
		} else {
			$_SESSION['error'] = 'Incorrect current password';
		}
	} else {
		$_SESSION['error'] = 'Fill up required details first';
	}

	// Redirect to the return page
	header('location:'.$return);
?>
