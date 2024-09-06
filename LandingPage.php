<?php
session_start();  // Start the session to access language preference

// Handle language change
if (isset($_POST['language'])) {
    $_SESSION['language'] = $_POST['language'];  // Store the selected language in session
}

// Check if a language is set via session, otherwise default to English
$language = isset($_SESSION['language']) ? $_SESSION['language'] : 'English';

include 'includes/conn.php';
include 'includes/languages.php';  // Include the language file
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votlink App</title>
    <link rel="stylesheet" href="/VoteLink/assets/css/style.css">
    <style>
        /* Add custom styles for the dropdown */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Votlink App</h1>
        <nav>
            <ul>
                <li><a href="/VoteLinkApp/index.php">Home</a></li>
                <li class="dropdown">
                    <a href="javascript:void(0)" class="dropbtn">Login</a>
                    <div class="dropdown-content">
                        <a href="/VoteLinkApp/Admin/login.php">Admin Login</a>
                        <a href="/VoteLinkApp/login.php">Voter Login</a>
                    </div>
                </li>
                <li><a href="/VoteLinkApp/register.php">Register</a></li>
            </ul>
        </nav>
        <!-- Language Selector Dropdown -->
        <form method="post" action="" style="float: right;">
            <select name="language" onchange="this.form.submit()">
                <option value="English" <?php echo ($language == 'English') ? 'selected' : ''; ?>>English</option>
                <option value="Luganda" <?php echo ($language == 'Luganda') ? 'selected' : ''; ?>>Luganda</option>
                <option value="Karamojong" <?php echo ($language == 'Karamojong') ? 'selected' : ''; ?>>Karamojong</option>
                <option value="Kiswahili" <?php echo ($language == 'Kiswahili') ? 'selected' : ''; ?>>Kiswahili</option>
            </select>
        </form>
    </header>

    <main>
        <section class="hero">
            <div class="hero-text">
                <h2><?php echo $texts[$language]['welcome']; ?></h2>
                <p><?php echo $texts[$language]['description']; ?></p>
                <a href="/VoteLinkApp/login.php" class="btn-primary"><?php echo $texts[$language]['login']; ?></a>
                <a href="/VoteLinkApp/register.php" class="btn-secondary"><?php echo $texts[$language]['register']; ?></a>
            </div>
            <div class="hero-image">
                <img src="/VoteLink/assets/images/voting.svg" alt="Voting Image">
            </div>
        </section>

        <section class="features">
            <h3><?php echo $texts[$language]['why_choose']; ?></h3>
            <div class="feature-cards">
                <div class="feature-card">
                    <img src="/VoteLink/assets/images/secure.svg" alt="Secure">
                    <h4><?php echo $texts[$language]['secure']; ?></h4>
                    <p><?php echo $texts[$language]['secure_desc']; ?></p>
                </div>
                <div class="feature-card">
                    <img src="/VoteLink/assets/images/easy.svg" alt="Easy">
                    <h4><?php echo $texts[$language]['easy']; ?></h4>
                    <p><?php echo $texts[$language]['easy_desc']; ?></p>
                </div>
                <div class="feature-card">
                    <img src="/VoteLink/assets/images/multi-language.svg" alt="Multi-language">
                    <h4><?php echo $texts[$language]['multi_language']; ?></h4>
                    <p><?php echo $texts[$language]['multi_language_desc']; ?></p>
                </div>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
