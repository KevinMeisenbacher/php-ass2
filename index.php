<?php
require_once('validate.php');
require_once('database.php');
require_once('db_admin.php');
require_once('file_util.php');  // set the $image_dir and $image_dir_path

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

if (!isset($_SESSION['is_valid_admin'])) {
	require_once('login_form.php');
}

$first_name = filter_input(INPUT_POST, 'first_name');
$first_name = filter_var($first_name, FILTER_SANITIZE_STRING);

$last_name = filter_input(INPUT_POST, 'last_name');
$last_name = filter_var($last_name, FILTER_SANITIZE_STRING);

$welcome_message = '';
if (isset($_SESSION['welcome_message'])) {
	$welcome_message = $_SESSION['welcome_message'];
}
// Get category ID
if (!isset($category_id)) {
  $category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
  if ($category_id == NULL || $category_id == FALSE) {
      $category_id = 1;
  }
}

// Get name for selected category
$queryCategory = 'SELECT * FROM categories
                      WHERE categoryID = :category_id';
$statement1 = $db->prepare($queryCategory);
$statement1->bindValue(':category_id', $category_id);
$statement1->execute();
$category = $statement1->fetch();
$category_name = $category['categoryName'];
$statement1->closeCursor();

// Get all categories
$queryAllCategories = 'SELECT * FROM categories
                           ORDER BY categoryID';
$statement2 = $db->prepare($queryAllCategories);
$statement2->execute();
$categories = $statement2->fetchAll();
$statement2->closeCursor();

// Get products for selected category
$queryProducts = 'SELECT * FROM products
              WHERE categoryID = :category_id
              ORDER BY productID';
$statement3 = $db->prepare($queryProducts);
$statement3->bindValue(':category_id', $category_id);
$statement3->execute();
$products = $statement3->fetchAll();
$statement3->closeCursor();
?>
<!DOCTYPE html>
<html>
<!-- the head section -->
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>

<!-- the body section -->
<body>
<main>
    <h1>Product List</h1>
	<h5>
	<?php if ($welcome_message != '') {
		echo $welcome_message;
	}?>
	</h5>
    <aside>
            <!-- display a list of categories -->
            <h2>Categories</h2>
            <nav>
            <ul>
                <?php foreach ($categories as $category) : ?>
                <li><a class="btn btn-block
                  <?php if($category['categoryID']==$category_id) {
                           echo "btn-success";
                        } else {
                           echo "btn-outline-success";
                        } ?>"
                        href=".?category_id=<?php echo $category['categoryID']; ?>">
                        <?php echo $category['categoryName']; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
            </nav>
			<br><br><br><br>
				<a class="btn btn-danger" href="logout.php" role="button">Log Out</a>
				<a class="btn btn-primary" href="add_user_form.php" role="button">Add User</a>
        </aside>

    <section>
        <!-- display a table of products -->
        <h2><?php echo $category_name; ?></h2>
        <table class="table table-striped">
			<thead>
              <tr>
                <th>Code</th>
                <th>Name</th>
                <th class="right">Price</th>
              </tr>
			</thead>
			<tbody>
			<!-- Define files and display everything -->
				<?php $files = scandir($image_dir_path);
				foreach ($products as $product) : 
				
				if (isset($_FILES['imageFile1'])) {
					// Retrieve the name of the file based on what it was called on the client computer
					$filename = $_FILES['imageFile1']['imageName'];
				} else {
					$filename = $product['productCode'] . '.png';
				}
				// Other image file initializer I was trying before
				/*if ($filename != $product['productCode'] . '.png') {
					$filename = 'noImage.png';
				} else {
					$filename = $product['productCode'] . '.png';
				}*/
				
				$file_url = $image_dir . DIRECTORY_SEPARATOR . $filename;?>
				<tr>
					<td><?php echo $product['productCode']; ?></td>
					<td><?php echo $product['productName']; ?></td>
					<td class="right"><?php echo $product['listPrice']; ?></td>
					<td><?php
					
						// Display instruments (to sight the stars)
						if(is_file($file_url) && exif_imagetype ($file_url)){
							?><img src=<?= $file_url ?> height=150px><?php ;
						}?>
					</td>
					<td>
						<!-- Big form for a little update button -->
						<form action="update_product_form.php" method="post">
	
						<!-- This hidden field is used to store the productID -->
						<input type="hidden" name="product_id_hidden"
								value="<?php echo $product['productID']; ?>">
	
						<!-- This is how to actually make things change when you update them -->
						<input type="hidden" name="category_id_hidden"
								value="<?php echo $product['categoryID']; ?>">
								
						<input type="hidden" name="name_hidden"
								value="<?php echo $product['productName']; ?>">
								
						<input type="hidden" name="code_hidden"
								value="<?php echo $product['productCode']; ?>">
								
						<input type="hidden" name="price_hidden"
								value="<?php echo $product['listPrice']; ?>">
			
						<!-- Actual Update button is here -->
						<input class="btn btn-primary" type="submit" value="Update">
						</form>
					</td>
				  
                    <!-- We are only showing the Delete button for this form -->
					<td>
						<form action="delete_product.php" method="post">
	
						<!-- This hidden field is used to store the productID -->
						<input type="hidden" name="product_id_hidden"
								value="<?php echo $product['productID']; ?>">
	
						<!-- This hidden field is used to store the categoryID -->
						<input type="hidden" name="category_id_hidden"
								value="<?php echo $product['categoryID']; ?>">
	
						<!-- This is the button that we actually see -->
						<input class="btn btn-warning" type="submit" value="Delete">
						</form>
					</td>
				</tr>
				<?php endforeach; ?>
				
			</tbody>
        </table>
        <a class="btn btn-primary" href="add_product_form.php" role="button">Add Product</a>
    </section>
</main>
<footer></footer>
</body>
</html>