<?php
    include 'includes/session.php';

    $return = 'home.php';
    if(isset($_GET['return'])){
        $return = $_GET['return'];
    }

    if(isset($_POST['save'])){
        $title = $_POST['title'];

        // Update the election title in the database
        $sql = "UPDATE config SET election_title = '$title' WHERE id = 1";
        if($conn->query($sql)){
            $_SESSION['success'] = 'Election title updated successfully';
        } else {
            $_SESSION['error'] = $conn->error;
        }
    } else {
        $_SESSION['error'] = "Fill up the config form first";
    }

    header('location: '.$return);
?>
