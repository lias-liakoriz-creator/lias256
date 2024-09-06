<?php
    session_start();
    include 'includes/session.php';
    include 'includes/slugify.php';

    $output = array('error' => false, 'list' => '');

    // Fetch positions from the database
    $sql = "SELECT * FROM positions";
    $query = $conn->query($sql);

    while ($row = $query->fetch_assoc()) {
        $position = slugify($row['description']);
        $pos_id = $row['position_id'];

        if (isset($_POST[$position])) {
            if ($row['max_vote'] > 1) {
                if (count($_POST[$position]) > $row['max_vote']) {
                    $output['error'] = true;
                    $output['message'][] = '<li>You can only choose ' . $row['max_vote'] . ' candidates for ' . $row['description'] . '</li>';
                } else {
                    foreach ($_POST[$position] as $key => $values) {
                        // Fetch candidate details
                        $sql = "SELECT * FROM candidates WHERE candidate_id = '$values'";
                        $cmquery = $conn->query($sql);
                        $cmrow = $cmquery->fetch_assoc();
                        $output['list'] .= "
                            <div class='row votelist'>
                                <span class='col-sm-4'><span class='pull-right'><b>" . $row['description'] . " :</b></span></span> 
                                <span class='col-sm-8'>" . $cmrow['firstname'] . " " . $cmrow['lastname'] . " (" . $cmrow['nickname'] . ")</span>
                            </div>
                        ";
                    }
                }
            } else {
                $candidate = $_POST[$position];
                // Fetch candidate details
                $sql = "SELECT * FROM candidates WHERE candidate_id = '$candidate'";
                $csquery = $conn->query($sql);
                $csrow = $csquery->fetch_assoc();
                $output['list'] .= "
                    <div class='row votelist'>
                        <span class='col-sm-4'><span class='pull-right'><b>" . $row['description'] . " :</b></span></span> 
                        <span class='col-sm-8'>" . $csrow['firstname'] . " " . $csrow['lastname'] . " (" . $csrow['nickname'] . ")</span>
                    </div>
                ";
            }
        }
    }

    echo json_encode($output);
?>
