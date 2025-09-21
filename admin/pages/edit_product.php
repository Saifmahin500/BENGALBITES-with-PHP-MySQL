<?php
include 'dbConfig.php';

if (!isset($_GET['id'])) {
	die('Invalid Request');
}

$decoded_id = base64_decode(urldecode($_GET['id']));

$stmt = $DB_con->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$decoded_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
	die("Product Not Found!");
}

// Handle Update
if (isset($_POST['update'])) {
	$productname = $_POST['product_name'];
	$description = $_POST['description'];
	$productstock = $_POST['product_stock'];
	$unit_price = $_POST['unit_price'];
	$selling_price = $_POST['selling_price'];
	$category_id = $_POST['category_id'];

	// Image Reupload
	$new_image = $product['product_image'];
	if (!empty($_FILES['product_image']['name'])) {
		$imgfile = $_FILES['product_image']['name'];
		$tem_dir = $_FILES['product_image']['tmp_name'];
		$imgext = strtolower(pathinfo($imgfile, PATHINFO_EXTENSION));
		$valid_extensions = ['jpg', 'jpeg', 'png', 'gif'];
		$upload_dir = "uploads/";

		if (in_array($imgext, $valid_extensions)) {
			$new_image = rand(1000, 1000000000) . "." . $imgext;
			move_uploaded_file($tem_dir, $upload_dir . $new_image);
			if (file_exists($upload_dir . $product['product_image'])) {
				unlink($upload_dir . $product['product_image']);
			}
		}
	}

	// Database Update
	$stmt = $DB_con->prepare("UPDATE products SET product_name = ?, description = ?, product_image = ?, unit_price = ?, selling_price = ?, stock_amount = ?, category_id = ? WHERE id = ?");
	$stmt->execute([$productname, $description, $new_image, $unit_price, $selling_price, $productstock, $category_id, $decoded_id]);

	$success = "Product updated successfully";
}

// All Categories Fetch
$cats = $DB_con->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
	<title>Update Product</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css">
</head>

<body>

	<div class="container mt-5">
		<h3 class="mb-4">Edit Product</h3>

		<?php
		if (!empty($success)) echo "<div class='alert alert-success'>$success</div>";
		?>

		<form method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<label>Product name:</label>
				<input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($product['product_name']) ?>">
			</div>

			<div class="form-group">
				<label>Description:</label>
				<textarea name="description" class="form-control"><?= htmlspecialchars($product['description']) ?></textarea>
			</div>

			<div class="form-group">
				<label>Stock Amount:</label>
				<input type="number" name="product_stock" class="form-control" value="<?= (int)$product['stock_amount'] ?>">
			</div>

			<div class="form-group">
				<label>Category:</label>
				<select name="category_id" class="form-control" required>
					<?php foreach ($cats as $cat): ?>
						<option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['category_name']); ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group">
				<label>Current Image:</label>
				<img src="uploads/<?= $product['product_image'] ?>" alt="Image Not Found" width="100"><br><br>
				<input type="file" name="product_image" class="form-control-file">
			</div>

			<div class="form-group">
				<label>Unit Price:</label>
				<input type="number" name="unit_price" class="form-control" value="<?= (int)$product['unit_price'] ?>">
			</div>

			<div class="form-group">
				<label>Selling Price:</label>
				<input type="number" name="selling_price" class="form-control" value="<?= (int)$product['selling_price'] ?>">
			</div>

			<button type="submit" name="update" class="btn btn-success">Update Product</button>
			<a href="?page=products" class="btn btn-secondary">Back</a>
		</form>
	</div>

</body>

</html>