<?php
session_start();  // Start the session to access language preference

// Check if a language is set via session, otherwise default to English
$language = isset($_SESSION['language']) ? $_SESSION['language'] : 'English';

include 'includes/conn.php';
include 'includes/languages.php';  // Include the language file
include 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nira_id = $_POST['nira_id'];

    // Check if NIRA ID exists and is eligible
    $query = "SELECT * FROM nira_data WHERE nira_id = ? AND is_eligible = 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nira_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $nira_data = $result->fetch_assoc();

        // Check if the user is already registered in the voters table
        $check_voter_query = "SELECT * FROM voters WHERE nira_id = ?";
        $voter_stmt = $conn->prepare($check_voter_query);
        $voter_stmt->bind_param("s", $nira_id);
        $voter_stmt->execute();
        $voter_result = $voter_stmt->get_result();

        if ($voter_result->num_rows > 0) {
            // User is already registered
            $error = $texts[$language]['already_registered'];
        } else {
            // Insert into voters table
            $insert_query = "INSERT INTO voters (nira_id, full_name, date_of_birth, gender, language)
                             VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sssss", $nira_data['nira_id'], $nira_data['full_name'], 
                              $nira_data['date_of_birth'], $nira_data['gender'], $language);

            if ($stmt->execute()) {
                // Send success message
                $success = $texts[$language]['registration_success'];

                // Optional: You can add code here to send an SMS notification to the voter
            } else {
                // Database insert failure
                $error = $texts[$language]['registration_fail'];
            }
        }
    } else {
        // NIRA ID not found or user not eligible
        $error = $texts[$language]['nira_not_found'];
    }
}
?>

<!-- HTML Form for Voter Registration -->
<link rel="stylesheet" href="/VoteLink/assets/css/style.css">

<body class="hold-transition login-page">
    <header>
        <h1><?php echo isset($texts[$language]['welcome']) ? $texts[$language]['welcome'] : 'Welcome'; ?> to Votlink App</h1>
        <nav>
            <ul>
                <li><a href="/VoteLinkApp/LandingPage.php"><?php echo isset($texts[$language]['Home']) ? $texts[$language]['Home'] : 'Home'; ?></a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn"><?php echo isset($texts[$language]['login']) ? $texts[$language]['login'] : 'Login'; ?></a>
                    <div class="dropdown-content">
                        <a href="/VoteLinkApp/Admin/login.php"><?php echo isset($texts[$language]['admin_login']) ? $texts[$language]['admin_login'] : 'Admin Login'; ?></a>
                        <a href="/VoteLinkApp/login.php"><?php echo isset($texts[$language]['login']) ? $texts[$language]['login'] : 'Login'; ?></a>
                    </div>
                </li>
                <li><a href="/VoteLinkApp/register.php"><?php echo isset($texts[$language]['register']) ? $texts[$language]['register'] : 'Register'; ?></a></li>
            </ul>
        </nav>
    </header>

    <div class="login-box">
        <div class="login-box-body">
            <h2 class="login-box-msg"><?php echo $texts[$language]['voter_registration']; ?></h2>

            <!-- Display Error Message -->
            <?php if ($error): ?>
                <div class='callout callout-danger text-center mt20'>
                    <p><?php echo $error; ?></p> 
                </div>
            <?php endif; ?>
            
            <!-- Display Success Message -->
            <?php if ($success): ?>
                <div class='callout callout-success text-center mt20'>
                    <p><?php echo $success; ?></p>
                </div>
            <?php endif; ?>

            <!-- Voter Registration Form -->
            <form action="" method="POST">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="nira_id" placeholder="<?php echo $texts[$language]['nira_id']; ?>" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo $texts[$language]['register']; ?></button>
                    </div>
                </div>
            </form>

            <p class="login-link"><?php echo $texts[$language]['already_registered']; ?> <a href="login.php"><?php echo $texts[$language]['login_here']; ?></a></p>
        </div>
    </div>

    <?php include 'includes/scripts.php'; ?>
</body>
</html>
