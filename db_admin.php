<?php
//Check if input password matches original password for the email address
function is_valid_admin_login($email, $password) {
	global $db;
	$query = 'SELECT password FROM administrators
			  WHERE emailAddress = :email';
	$statement = $db->prepare($query);
	$statement->bindValue(':email', $email);
	$statement->execute();
	$row = $statement->fetch();
	$statement->closeCursor();
	$hash = $row['password'];
	echo $hash, '<br>';
	echo $password, '<br>';
	return password_verify($password, $hash);
}

//Query the database to check if an input email already exists
function email_exists($email) {
	global $db;
	$query =
		'SELECT * FROM administrators
		WHERE emailAddress = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
	
	return $statement->rowCount() > 0;
}

//Add a user to Administrators based on email, password, first name and last name
function add_admin($email, $password, $firstname, $lastname) {
	
	$email = strtolower($email);
	
	if (email_exists($email)) {
		return "You might already have an account with us because that email already exists.";
	} else {
		global $db;
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$query =
			'INSERT INTO administrators (emailAddress, password, firstname, lastname)
			VALUES (:email, :password, :firstname, :lastname)';
		$statement = $db->prepare($query);
		$statement->bindValue(':email', $email);
		$statement->bindValue(':password', $hash);
		$statement->bindValue(':firstname', $firstname);
		$statement->bindValue(':lastname', $lastname);
		$statement->execute();
		
		$returnMessage = "Welcome, " . $firstname . ' ' . $lastname;
		$errorCode = $statement->errorCode();
		
		if ($errorCode !== "00000") {
			$returnMessage = "There was an error creating the user with code $errorCode";
		}
		$statement->closeCursor();
		return $returnMessage;
	}
}

?>