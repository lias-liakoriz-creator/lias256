<?php
  	session_start();
  	// Check if the admin is already logged in
  	if(isset($_SESSION['admin'])){
    	header('location:home.php');
  	}

  	// Check if the form is submitted
  	if(isset($_POST['login'])){
      	// Database connection
      	include 'includes/conn.php';

      	$username = $_POST['username'];
      	$password = $_POST['password'];

      	// SQL query to check if the user exists in the admins table
      	$sql = "SELECT * FROM admins WHERE username = '$username'";
      	$query = $conn->query($sql);

      	if($query->num_rows > 0){
          	$row = $query->fetch_assoc();
          	// Verify password
          	if(password_verify($password, $row['password'])){
              	$_SESSION['admin'] = $row['admin_id'];
              	header('location:home.php');
          	} else {
              	$_SESSION['error'] = 'Incorrect Password';
          	}
      	} else {
          	$_SESSION['error'] = 'Username not found';
      	}
  	}
?>
<?php include 'includes/header.php'; 
include 'includes/languages.php';?>
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
<body class="hold-transition login-page">
<div class="login-box">
  
  	<div class="login-box-body">
    	<p class="login-box-msg">Sign in to start your session</p>

    	<form action="login.php" method="POST">
      		<div class="form-group has-feedback">
        		<input type="text" class="form-control" name="username" placeholder="Username" required>
        		<span class="glyphicon glyphicon-user form-control-feedback"></span>
      		</div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
      		<div class="row">
    			<div class="col-xs-4">
          			<button type="submit" class="btn btn-primary btn-block btn-flat" name="login"><i class="fa fa-sign-in"></i> Sign In</button>
        		</div>
      		</div>
    	</form>
  	</div>
  	<?php
  		if(isset($_SESSION['error'])){
  			echo "
  				<div class='callout callout-danger text-center mt20'>
			  		<p>".$_SESSION['error']."</p> 
			  	</div>
  			";
  			unset($_SESSION['error']);
  		}
  	?>
</div>
	
<?php include 'includes/scripts.php' ?>
</body>
</html>
