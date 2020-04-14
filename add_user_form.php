<?php

//Setting our default values to empty string if they don't exist
if(!isset($email)){ $email = ''; }
if(!isset($first_name)){ $first_name = ''; }
if(!isset($last_name)){ $last_name = ''; }
if(!isset($add_return_value)){ $add_return_value = ''; }
?>
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>Add User Form</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<!-- the body section -->
<body>
    <div class="container">
    <header><h1>Add User</h1></header>

    <main>
        <h1>User Information</h1>
		<?php if(isset($add_return_value) && $add_return_value != ''){ ?>
            <h5 class='text-primary'><?= $add_return_value; ?></h3>
        <?php } ?>

        <form action="add_user.php" method="post"
              id="add_user_form">

            <!-- start of the email/username section -->
            <div class="form-group">

                <label for="code">Username/Email:</label>

                <?php if(isset($email_error) && $email_error != ''){ ?>
                    <h5 class='text-danger'><?= $email_error; ?></h3>
                <?php } ?>

                <input class="form-control" type="email" name="email" id="email"
                value="<?= htmlspecialchars($email); ?>"><br>
            </div>

            <!-- start of the first name section -->
            <div class="form-group">
                <label for="name">First Name:</label>
                <?php if(isset($firstname_error) && $firstname_error != ''){ ?>
                    <h5 class='text-danger'><?= $firstname_error; ?></h3>
                <?php } ?>
                <input class="form-control" type="text" name="first_name" id="first_name"
                value="<?= htmlspecialchars($first_name); ?>"><br>
            </div>

            <!-- start of the Last Name section -->
            <div class="form-group">
                <label for="name">Last Name:</label>
                <?php if(isset($lastname_error) && $lastname_error != ''){ ?>
                    <h5 class='text-danger'><?= $lastname_error; ?></h3>
                <?php } ?>
                <input class="form-control" type="text" name="last_name" id="last_name"
                value="<?= htmlspecialchars($last_name); ?>"><br>
            </div>

            <!-- start of the Password section -->
            <div class="form-group">

                <label for="price">Password:</label>

                <?php if(isset($password_error) && $password_error != ''){ ?>
                    <h5 class='text-danger'><?= $password_error; ?></h3>
                <?php } ?>

                <input class="form-control" type="password" name="password" id="password"
                value=""><br>
            </div>

            <!-- start of the Confirm Password section -->
            <div class="form-group">

                <label for="price">Confirm Password:</label>

                <?php if(isset($confirm_password_error) && $confirm_password_error != ''){ ?>
                    <h5 class='text-danger'><?= $confirm_password_error; ?></h3>
                <?php } ?>

                <input class="form-control" type="password" name="confirm_password" id="confirm_password" value=""><br>
            </div>

            <!-- Submit button for the form -->
            <label>&nbsp;</label>
            <input class="btn btn-primary" type="submit" value="Add User"><br>
        </form>
    </main>
    </div>
</body>
</html>