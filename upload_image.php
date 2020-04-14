<?php

require_once 'file_util.php';  // set the $image_dir and $image_dir_path

//This is where we will add the code to move the uploaded file to the images directory

// Check if the file exists before setting it
if (isset($_FILES['imageFile1'])) {
	// Retrieve the name of the file based on what it was called on the client computer
	$filename = $_FILES['imageFile1']['name'];

	// Make sure the filename exists 
	if (!empty($filename)) {
		// Store the temporary location of where the file was stored on the server
		$sourceLocation = $_FILES['imageFile1']['tmp_name'];
		
		// Build the path to the images folder and use the same filename as before
		$targetPath = $image_dir_path . DIRECTORY_SEPARATOR . $filename;
		
		// Move file from temp directory to images folder
		move_uploaded_file($sourceLocation, $targetPath);
	}
}

header("Location: ./index.php");
?>