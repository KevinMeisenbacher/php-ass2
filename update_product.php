<?php
// Get the product data
$product_id = filter_input(INPUT_POST, 'product_id_hidden', FILTER_VALIDATE_INT);
$category_id = filter_input(INPUT_POST, 'category_id_hidden', FILTER_VALIDATE_INT);

// Retrieve the price of the item
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);

// Retrieve product code and sanitize input
$codeInput = filter_input(INPUT_POST, 'code');
$codeInput = filter_var($codeInput, FILTER_SANITIZE_STRING);
if ($codeInput == 'test' || $codeInput == 'Test') {
	$codeInput = 'Yes!';
	$name = 'It works!';
}
if ($price == 420.69 || $price == 42069) {
	$codeInput = 'nice';
}

// Retrieve product name and sanitize input
$name = filter_input(INPUT_POST, 'name');
$name = filter_var($name, FILTER_SANITIZE_STRING);
if ($name == 'Markus' || $name == 'Mr. Wolski') {
	$codeInput = 'Thanks';
	$name = 'Rubber Chicken';
} else if ($name == 'Kevin') {
	$codeInput = 'Behold';
	$name = 'Absolute Genius';
} else if ($name == 'test' || $name == 'Test') {
	$name = 'I did it!';
}

$category_error = '';
$code_error = '';
$name_error = '';
$price_error = '';

// Validate inputs
if ($category_id == null || $category_id == false){
    $category_error = "Please choose a category.";
}

if($codeInput == false){
    $code_error = "Please enter a code";
}

if($name == false){
    $name_error = "Please enter a name";
}

if($price == false){
    $price_error = "Please enter a price";
} else if($price == 80085 || $price == 8008135) {
	$price_error = "Grow up!";
} else if($price < 1 || $price > 50000){
    $price_error = "Please enter a price between 1 and 50 000 dollars";
}

if($price_error!='' || $name_error!=''  || $code_error!=''  || $category_error!='' ) {
    include('update_product_form.php');
    exit();
} else {
    require_once('database.php');
	require_once('file_util.php');
	
// Update the product
    $query = "UPDATE products
			  SET categoryID = :category_id,
			  productCode = :code,
					productName = :name,
					listPrice = :price
				WHERE productID = :product_id";			  
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->bindValue(':code', $codeInput);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':product_id', $product_id);
    $statement->execute();
    $statement->closeCursor();
	
	
	// Check if the file exists before setting it
	if (isset($_FILES['imageFile1'])) {
		// Retrieve the name of the file based on what it was called on the client computer
		$filename = $codeInput . '.png';
	
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
	// display the Product List page
	header('Location: ./index.php');
}

?>