<?php
    session_start();
    include 'includes/conn.php'; // Make sure this file connects to the correct database

    if(isset($_POST['login'])){
        $nira_id = $_POST['nira_id'];
        $voter_id = $_POST['voter_id'];

        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'votlinkapp_db');

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Verify NIN and Voter ID
        $sql = "SELECT * FROM voters WHERE nira_id = '$nira_id' AND voter_id = '$voter_id'";
        $query = $conn->query($sql);

        if($query->num_rows > 0){
            $row = $query->fetch_assoc();
            $_SESSION['voter'] = $row['voter_id'];
            header('location: home.php');
        }
        else{
            $_SESSION['error'] = 'Invalid NIN or Voter ID';
            header('location: index.php');
        }

        $conn->close();
    }
    else{
        $_SESSION['error'] = 'Please fill in both fields';
        header('location: index.php');
    }
?>
