<?php
    include 'includes/session.php';

    if(isset($_POST['add'])){
        $position_name = $_POST['position_name'];
        $max_vote = $_POST['max_vote'];

        // Fetch the current highest priority from the positions table
        $sql = "SELECT * FROM positions ORDER BY priority DESC LIMIT 1";
        $query = $conn->query($sql);
        $row = $query->fetch_assoc();

        // Calculate the new priority
        $priority = $row['priority'] + 1;

        // Insert the new position into the positions table
        $sql = "INSERT INTO positions (position_name, max_vote, priority) VALUES ('$position_name', '$max_vote', '$priority')";
        if($conn->query($sql)){
            $_SESSION['success'] = 'Position added successfully';
        }
        else{
            $_SESSION['error'] = $conn->error;
        }

    }
    else{
        $_SESSION['error'] = 'Fill up add form first';
    }

    header('location: positions.php');
?>
