<?php
require_once('file-util.php');

// Get IDs
$filename = filter_input(INPUT_POST, 'filename', FILTER_VALIDATE_INT);

// Delete the product from the database
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
		unlink($targetParh);
	}
}

// display the Product List page
include('index.php');
?>