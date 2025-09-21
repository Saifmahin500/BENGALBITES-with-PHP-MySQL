<?php

include 'dbConfig.php';

if(isset($_GET['view_id']))
{
	$view_id = (int)base64_decode(urldecode($_GET['view_id']));
	$stmt = $DB_con->prepare("SELECT * FROM products WHERE id = ?");
	$stmt->execute([$view_id]);
	$products =$stmt->fetchAll(PDO::FETCH_ASSOC);


}


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		View Products
	</title>
</head>
<body>
	<?php foreach($products as $row):?>
	<div>
		<img src="uploads/<?php echo htmlspecialchars($row['product_image']); ?>" alt="No image found" class="thumbnail-img">
		
	</div>
	<div>
		<p>Name:<?= $row['product_name']?></p>
	</div>
	<div>
		<p>Descriptions:<?= $row['description']?></p>
	</div>
	<div>
		<p>Unit Price:<?= $row['unit_price']?></p>
	</div>
	<div>
		<p>Stock Amount:<?= $row['stock_amount']?></p>
	</div>
<?php endforeach;?>

</body>
</html>