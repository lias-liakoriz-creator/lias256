<?php
	session_start();
	include 'includes/conn.php';

	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];

		// Query the `admins` table
		$sql = "SELECT * FROM admins WHERE username = '$username'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'Cannot find account with the username';
		}
		else{
			$row = $query->fetch_assoc();
			// Check if the plain text password matches
			if($password == $row['password']){ // Direct comparison of plain text password
				$_SESSION['admin'] = $row['admin_id'];
				header('location: home.php'); // Redirect to home page after login
			}
			else{
				$_SESSION['error'] = 'Incorrect password';
			}
		}
	}
	else{
		$_SESSION['error'] = 'Input admin credentials first';
	}

	header('location: index.php');
?>
