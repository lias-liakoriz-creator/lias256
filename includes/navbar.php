<header class="main-header">
  <nav class="navbar navbar-static-top">
    <div class="container">
      <div class="navbar-header">
        <a href="#" class="navbar-brand"><b>VotLink</b>App</a>
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
          <i class="fa fa-bars"></i>
        </button>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <?php
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            if(isset($_SESSION['voter_id'])){
              echo "
                <li><a href='index.php'>HOME</a></li>
                <li><a href='transaction.php'>TRANSACTION</a></li>
              ";
            } 
          ?>
        </ul>
      </div>
      <!-- /.navbar-collapse -->
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="user user-menu">
            <a href="">
              <?php
                // Connect to the database
                $conn = new mysqli('localhost', 'root', '', 'votlink_db');

                // Check the connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Get the voter details
                if(isset($_SESSION['voter_id'])){
                  $voter_id = $_SESSION['voter_id'];
                  $sql = "SELECT * FROM voters WHERE voter_id = '$voter_id'";
                  $result = $conn->query($sql);
                  $voter = $result->fetch_assoc();
                }

                // Display voter details if logged in
                if(isset($voter)){
                  $photo = (!empty($voter['photo'])) ? 'images/'.$voter['photo'] : 'images/profile.jpg';
                  echo "
                    <img src='$photo' class='user-image' alt='User Image'>
                    <span class='hidden-xs'>".$voter['full_name']."</span>
                  ";
                }
                // Removed $conn->close(); to keep the connection open
              ?>
            </a>
          </li>
          <li><a href="logout.php"><i class="fa fa-sign-out"></i> LOGOUT</a></li>  
        </ul>
      </div>
      <!-- /.navbar-custom-menu -->
    </div>
    <!-- /.container-fluid -->
  </nav>
</header>
