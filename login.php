<?php

    //Check to see if there is no session yet
    if (session_status() == PHP_SESSION_NONE) {
        //Start the session since there is no session
        session_start();
    }

    // get the data from the form
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password');

    //Clearing our the messages from the session if they already exist
    unset($_SESSION['email_message']);
    unset($_SESSION['password_message']);
    unset($_SESSION['login_message']);

    //Validate email
    if ( $email === FALSE ) {
        $_SESSION['email_message'] = 'Please provide a valid email address.';
    }

    //validate password
    if ( $password === FALSE || strlen($password) < 6 ) {
        $_SESSION['password_message'] = 'Please provide a password at least 6 characters long.';
    }

    // if an error message exists, go to the index page
    if (isset($_SESSION['password_message']) ||
        isset($_SESSION['email_message'])) {

        $_SESSION['email'] = $email;

        //We could use include('index.php'); or header('Location: ./index.php'); here
        header('Location: ./login_form.php');
        exit();
    } else {
		require_once('database.php');
		require_once('db_admin.php');
        //Here is where we need to validate the user and set the session
		if (is_valid_admin_login($email, $password)) {
			$_SESSION['is_valid_admin'] = true;
			header('Location: ./index.php');
			
			// This big query command gets the user's first name
			$query = 'SELECT firstname FROM administrators
						WHERE emailAddress = :email';
			$statement = $db->prepare($query);
			$statement->bindValue(':email', $email);
			$statement->execute();
			$row = $statement->fetch();
			$statement->closeCursor();
			$name = $row['firstname'];
			
			// This big query command gets the user's last name
			$query = 'SELECT lastname FROM administrators
						WHERE emailAddress = :email';
			$statement2 = $db->prepare($query);
			$statement2->bindValue(':email', $email);
			$statement2->execute();
			$row2 = $statement2->fetch();
			$statement2->closeCursor();
			$name2 = $row2['lastname'];
			
			// Creates the welcome message to be used in index.php
			$_SESSION['welcome_message'] = 'Welcome back, ' . $name . ' ' . $name2;
		} else {
			if (email_exists($email)) {
				//Correct email
				$_SESSION['login_message'] = 'Incorrect password';
			} else {
				//Incorrect email
				$_SESSION['login_message'] = 'Cannot find that username in our database';
			}
			header('location: ./login_form.php');
			exit();
		}
	}
?>
