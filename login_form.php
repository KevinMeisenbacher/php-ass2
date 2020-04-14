<?php

    //If we want to use the session we need to start it first
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    //Default to the empty string
    $password_message = '';

    //Check to see if there is a pasword_message set in the session
    if(isset($_SESSION['password_message'])){
      //retrieve the pasword_message in the session and put it in our local variable
      $password_message = $_SESSION['password_message'];
    }

    $email_message = '';
    if(isset($_SESSION['email_message'])){
      $email_message = $_SESSION['email_message'];
    }

    $email = '';
    if(isset($_SESSION['email'])){
      $email = $_SESSION['email'];
    }
	
	$login_message = '';
    if(isset($_SESSION['login_message'])){
      $login_message = $_SESSION['login_message'];
    }


?>
<!DOCTYPE html>
<html>

<!-- our header imports for bootstrap, jquery and our title -->
<head>
    <title>Sign-In Form</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	  <link href='https://fonts.googleapis.com/css?family=Alfa Slab One' rel='stylesheet'>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<!-- The body containing our form and image -->
<body>
    <br>

    <!-- The div containing our form with bootstrap styling -->
    <div class="container border text-white bg-success rounded">
        <br>

        <!-- Title for the form -->
        <h4 class="text-center">GUITARLAND</h4>
		<div class="blockyFont">
			<h4 class="blockyFont">SIGN IN</h4>
		</div>
		
		<!-- Let the user know if their username/password is incorrect -->
		<?php if ($login_message !='') { ?>
          <h4 class="text-danger"><?php echo htmlspecialchars($login_message); ?></h4>
        <?php } ?>

        <!-- The form where we have to set the php file that will display our results -->
        <form action="login.php" method="post">

            <!-- This is for our name -->
            <div class="form-group">
              <label for="email">Email:</label>
              <?php if ($email_message !='') { ?>
                <h4 class="text-danger"><?php echo htmlspecialchars($email_message); ?></h4>
              <?php } ?>
              <input type="email" class="form-control" id="email" name="email"
              value="<?php echo htmlspecialchars($email); ?>">
            </div>

            <!-- This is for our password -->
            <div class="form-group">

              <!-- The label for our password -->
              <label for="pwd">Password:</label>

              <!-- Checking to see if we have an error message in the session -->
              <!-- Display the error message if it is not empty -->
              <?php if ($password_message !='') { ?>
                <h4 class="text-danger"><?php echo htmlspecialchars($password_message); ?></h4>
              <?php } ?>

              <!-- The input for our password. type="password" so that the **** symbols are used instead of showing the text -->
              <input type="password" class="form-control" id="pwd" name="password"
              value="">
            </div>

            <!-- The submit button for out form with bootstrap styling -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </div>
    <br>

</body>
</html>