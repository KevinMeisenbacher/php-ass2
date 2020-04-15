<!DOCTYPE html>
<html>
<head>
    <title>Upload Image</title>
    <link rel="stylesheet" type="text/css" href="main.css"/>
</head>
<body>
    <header>
        <h1>Upload Image</h1>
    </header>
    <main>
        <h2>Image to be uploaded</h2>
        <!--This is where we will create the form to upload our image -->
		<form id="upload_form"
			action="upload_image.php" method="POST"
			enctype="multipart/form-data">
			
			<input type="file" name="imageFile1"><br>
			<input id="upload_button" type="submit" value="Upload">
		</form>
    </main>
    <a class="btn btn-primary" href="./index.php" role="button">Back to images</a>
</body>
</html>