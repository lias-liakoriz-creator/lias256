<?php
	include 'includes/session.php';

	if(isset($_POST['add'])){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		$filename = $_FILES['photo']['name'];
		
		if(!empty($filename)){
			move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$filename);	
		}

		// Generate a unique NIRA ID (example method for generating NIRA ID, ensure this aligns with your application requirements)
		$nira_id = 'NIRA' . substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 5);

		// Concatenate first name and last name for full name
		$full_name = $firstname . ' ' . $lastname;

		// Define other necessary fields for the insertion (these are placeholders, adjust them based on your form inputs)
		$date_of_birth = '1990-01-01'; // Replace with actual value from form if available
		$gender = 'Male'; // Replace with actual value from form if available
		$language = 'English'; // Replace with actual value from form if available

		// Insert voter into the `voters` table
		$sql = "INSERT INTO voters (nira_id, full_name, date_of_birth, gender, language, photo) 
				VALUES ('$nira_id', '$full_name', '$date_of_birth', '$gender', '$language', '$filename')";
		if($conn->query($sql)){
			$_SESSION['success'] = 'Voter added successfully';
		} else {
			$_SESSION['error'] = $conn->error;
		}
	} else {
		$_SESSION['error'] = 'Fill up add form first';
	}

	header('location: voters.php');
?>
