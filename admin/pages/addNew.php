<?php
error_reporting(0);
include 'dbConfig.php';

$errmsg = '';
$successmsg = '';

// Fetch Categories
$cat_stmt = $DB_con->prepare("SELECT * FROM categories");
$cat_stmt->execute();
$categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['btnsave'])) {
	$productname = $_POST['product_name'];
	$description = $_POST['description'];
	$productstock = $_POST['product_stock'];
	$category_id = $_POST['category_id'];
	$unit_price = $_POST['unit_price'];
	$selling_price = $_POST['selling_price'];

	// Product Image Upload
	$image_name = '';
	if (!empty($_FILES['product_image']['name'])) {
		$image_name = time() . '_' . $_FILES['product_image']['name'];
		move_uploaded_file($_FILES['product_image']['tmp_name'], "uploads/" . $image_name);
	}

	if (empty($errmsg)) {
		$stmt = $DB_con->prepare("INSERT INTO products (product_name, description, product_image, unit_price, selling_price, stock_amount, category_id, created_at) 
                                  VALUES (:pname, :pdesc, :ppic, :uprice, :sprice, :pstock, :cat_id, current_timestamp())");

		$stmt->bindParam(':pname', $productname);
		$stmt->bindParam(':pdesc', $description);
		$stmt->bindParam(':ppic', $image_name);
		$stmt->bindParam(':uprice', $unit_price);
		$stmt->bindParam(':sprice', $selling_price);
		$stmt->bindParam(':pstock', $productstock);
		$stmt->bindParam(':cat_id', $category_id);

		if ($stmt->execute()) {
			$successmsg = "New Product Inserted Successfully";
		} else {
			$errmsg = "Error while inserting";
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Add New Products</title>
	<!-- Bootstrap and Custom Styles -->
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
	<div class="container mt-5">
		<h3>Add New Product</h3>

		<?php if (!empty($errmsg)) echo "<div class='alert alert-danger'>$errmsg</div>"; ?>
		<?php if (!empty($successmsg)) echo "<div class='alert alert-success'>$successmsg</div>"; ?>

		<form method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label for="product_name">Product Name:</label>
				<input type="text" id="product_name" name="product_name" class="form-control" required>
			</div>

			<div class="form-group">
				<label for="description">Description:</label>
				<textarea id="description" name="description" class="form-control" rows="4"></textarea>
			</div>

			<div class="form-group">
				<label for="product_image">Product Image:</label>
				<input type="file" id="product_image" name="product_image" class="form-control" required>
			</div>

			<div class="form-group">
				<label for="unit_price">Unit Price:</label>
				<input type="number" id="unit_price" name="unit_price" class="form-control" required>
			</div>

			<div class="form-group">
				<label for="selling_price">Selling Price:</label>
				<input type="number" id="selling_price" name="selling_price" class="form-control" required>
			</div>

			<div class="form-group">
				<label for="product_stock">Stock Amount:</label>
				<input type="number" id="product_stock" name="product_stock" class="form-control" required>
			</div>

			<div class="form-group">
				<label for="category_id">Category:</label>
				<select name="category_id" id="categorySelect" class="form-control" required>
					<option value="">Select Category</option>
					<?php foreach ($categories as $cat): ?>
						<option value="<?= $cat['id']; ?>"><?= htmlspecialchars($cat['category_name']); ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<button type="submit" name="btnsave" class="btn btn-success">Save</button>
		</form>
	</div>
</body>

</html>