<?php
    include 'includes/session.php';

    if(isset($_POST['delete'])){
        $id = $_POST['id'];

        // Use position_id instead of id to match the column name in the positions table
        $sql = "DELETE FROM positions WHERE position_id = '$id'";
        if($conn->query($sql)){
            $_SESSION['success'] = 'Position deleted successfully';
        }
        else{
            $_SESSION['error'] = $conn->error;
        }
    }
    else{
        $_SESSION['error'] = 'Select item to delete first';
    }

    header('location: positions.php');
?>
