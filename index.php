<?php
session_start();

// Check if a language is set via session, otherwise default to English
$language = isset($_SESSION['language']) ? $_SESSION['language'] : 'English';

// Redirect if the user is already logged in
if (isset($_SESSION['admin'])) {
    header('location: admin/home.php');
}

if (isset($_SESSION['voter'])) {
    header('location: home.php');
}

include 'includes/header.php';
include 'includes/languages.php'; // Include the language file for dynamic text

?>
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
            <p class="login-box-msg"><?php echo isset($texts[$language]['enter_credentials']) ? $texts[$language]['enter_credentials'] : 'Enter Your Credentials'; ?></p>

            <form action="login.php" method="POST">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="nira_id" placeholder="<?php echo isset($texts[$language]['nira_id']) ? $texts[$language]['nira_id'] : 'NIN (NIRA ID)'; ?>" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="voter_id" placeholder="<?php echo isset($texts[$language]['voter_id']) ? $texts[$language]['voter_id'] : 'Voter ID'; ?>" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat" name="login">
                            <i class="fa fa-sign-in"></i> <?php echo isset($texts[$language]['sign_in']) ? $texts[$language]['sign_in'] : 'Sign In'; ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        

        <?php
        if (isset($_SESSION['error'])) {
            echo "
                <div class='callout callout-danger text-center mt20'>
                    <p>" . $_SESSION['error'] . "</p> 
                </div>
            ";
            unset($_SESSION['error']);
        }
        ?>
    </div>

    <?php include 'includes/scripts.php'; ?>
</body>
</html>
