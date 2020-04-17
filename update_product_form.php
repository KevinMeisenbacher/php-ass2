<?php
require_once('validate.php');
require_once('database.php');
require_once('db_admin.php');
// Initialize everything to its corresponding variable. Needed for my hard work to actually pay off
if(!isset($codeInput)){
    $codeInput = filter_input(INPUT_POST, 'code_hidden');
}
if(!isset($price)){
    $price = filter_input(INPUT_POST, 'price_hidden', FILTER_VALIDATE_FLOAT);
}
if(!isset($name)){
    $name = filter_input(INPUT_POST, 'name_hidden');
}
if(!isset($product_id)){
    $product_id = filter_input(INPUT_POST, 'product_id_hidden', FILTER_VALIDATE_INT);
}

// Basically make this file read the database
require('database.php');

// Make categories show
$query = 'SELECT *
          FROM categories
          ORDER BY categoryID';
$statement = $db->prepare($query);
$statement->execute();
$categories = $statement->fetchAll();
$statement->closeCursor();

// Query magic that shows products to other files
$queryProducts = 'SELECT * FROM products
				  WHERE productID = :product_id_hidden
				  ORDER BY productID';
$statement2 = $db->prepare($queryProducts);
$statement2->bindValue(':product_id_hidden', $product_id);
$statement2->execute();
$products = $statement2->fetchAll();
$statement2->closeCursor();
?>
<!DOCTYPE html>
<html>

<head>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">
    <header><h1>Product Manager</h1></header>

    <main>
        <h1>Update Product</h1>

        <form action="update_product.php" method="post"
              id="update_product_form">
			  
			<input type="hidden" name="product_id_hidden"
			value="<?php echo $product_id;?>">

            <div class="form-group">
                <label>Category:</label>
                <?php if(isset($category_error) && $category_error != ''){ ?>
                    <h3 class='text-danger'><?php echo $category_error; ?></h3>
                <?php } ?>
                <select class="form-control" name="category_id_hidden">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category['categoryID']; ?>">
                        <?php echo $category['categoryName']; ?>
                    </option>
                <?php endforeach; ?>
                </select><br>
            </div>

            <div class="form-group">
                <label for="code">Code:</label>
                <?php if(isset($code_error) && $code_error != ''){ ?>
                    <h3 class='text-danger'><?php echo $code_error; ?></h3>
                <?php } ?>
                <input class="form-control" type="text" name="code" id="code"
                value="<?php echo htmlspecialchars($codeInput); ?>"><br>
            </div>

            <div class="form-group">
                <label for="name">Name:</label>
                <?php if(isset($name_error) && $name_error != ''){ ?>
                    <h3 class='text-danger'><?php echo $name_error; ?></h3>
                <?php } ?>
                <input class="form-control" type="text" name="name" id="name"
                value="<?php echo htmlspecialchars($name); ?>"><br>
            </div>

            <div class="form-group">
                <label for="price">List Price:</label>
                <?php if(isset($price_error) && $price_error != ''){ ?>
                    <h3 class='text-danger'><?php echo $price_error; ?></h3>
                <?php } ?>
                <input class="form-control" type="text" name="price" id="price"
                value="<?php echo htmlspecialchars($price); ?>"><br>
            </div>
			
			<!-- Image Uploader -->
			<div class="form-group">
                <input type="file" class="btn btn-light" name="imageFile1"><br>
            </div>

            <label>&nbsp;</label>
            <input class="btn btn-primary" type="submit" value="Update Product"><br>
        </form>
        <p><br><a href="index.php">View Product List</a></p>
		<a class="btn btn-danger" href="logout.php" role="button">Log Out</a>
		<a class="btn btn-primary" href="add_user_form.php" role="button">Add User</a>
    </main>
    </div>
</body>
</html>