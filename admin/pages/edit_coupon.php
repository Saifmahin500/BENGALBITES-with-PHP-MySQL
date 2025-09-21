<?php
if(session_status() == PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['admin_logged_in'])) { header("Location: ../login.php"); exit; }

require_once __DIR__ .'/../dbConfig.php';

// Categories
$cats = $DB_con->query("SELECT id, category_name FROM categories ORDER BY category_name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Get coupon ID
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) die("Invalid request!");
$id = (int)$_GET['id'];

// Load coupon
$coupon = $DB_con->prepare("SELECT * FROM coupons WHERE id=?");
$coupon->execute([$id]);
$coupon = $coupon->fetch(PDO::FETCH_ASSOC);
if(!$coupon) die("Coupon not found!");

// Load selected product if scope=product
$selectedProduct = null;
if($coupon['scope'] === 'product') {
    $stmt = $DB_con->prepare("SELECT p.id, p.product_name, p.category_id 
                              FROM products p 
                              INNER JOIN coupon_products cp ON cp.product_id = p.id
                              WHERE cp.coupon_id=?");
    $stmt->execute([$id]);
    $selectedProduct = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Handle POST
if($_SERVER['REQUEST_METHOD']==='POST'){
    $code = $_POST['code'];
    $discount_percent = $_POST['discount_percent'];
    $scope = $_POST['scope'];
    $status = $_POST['status'];
    $start_date = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
    $end_date = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
    $usage_limit = !empty($_POST['usage_limit']) ? (int)$_POST['usage_limit'] : 0;

    // Update coupon
    $upd = $DB_con->prepare("UPDATE coupons SET code=?, discount_percent=?, scope=?, status=?, start_date=?, end_date=?, usage_limit=? WHERE id=?");
    $ok = $upd->execute([$code,$discount_percent,$scope,$status,$start_date,$end_date,$usage_limit,$id]);

    if($ok)
    {
        if($scope==='product' && isset($_POST['product_id'])){
            $pid = (int)$_POST['product_id'];
            // আগের products remove করে নতুন product insert
            $DB_con->prepare("DELETE FROM coupon_products WHERE coupon_id=?")->execute([$id]);
            $DB_con->prepare("INSERT INTO coupon_products(coupon_id,product_id) VALUES(?,?)")->execute([$id,$pid]);
        }
        else
        {
            // scope all বা category হলে coupon_products থেকে আগের data remove
            $DB_con->prepare("DELETE FROM coupon_products WHERE coupon_id=?")->execute([$id]);
        }
        header("Location: ?page=coupons");
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Coupon</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
<h2>Edit Coupon</h2>

<form method="POST">
<div class="mb-3">
<label class="form-label">Coupon Code</label>
<input type="text" name="code" class="form-control" value="<?= htmlspecialchars($coupon['code']) ?>" required>
</div>

<div class="mb-3">
<label class="form-label">Discount %</label>
<input type="number" step="0.01" name="discount_percent" class="form-control" value="<?= $coupon['discount_percent'] ?>" required>
</div>

<div class="mb-3">
<label class="form-label">Scope</label>
<select name="scope" id="scopeSelect" class="form-select" required>
    <option value="all" <?= $coupon['scope']==='all'?'selected':'' ?>>All</option>
    <option value="category" <?= $coupon['scope']==='category'?'selected':'' ?>>Category</option>
    <option value="product" <?= $coupon['scope']==='product'?'selected':'' ?>>Product</option>
</select>
</div>

<div id="productDiv" style="display:<?= $coupon['scope']==='product'?'block':'none' ?>;">
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select id="catSelect" class="form-select">
            <option value="">-- Choose Category --</option>
            <?php foreach($cats as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $selectedProduct && $selectedProduct['category_id']==$c['id']?'selected':'' ?>><?= $c['category_name'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Product</label>
        <select name="product_id" id="prodSelect" class="form-select">
            <option value="">-- Choose Product --</option>
            <?php if($selectedProduct): ?>
                <option value="<?= $selectedProduct['id'] ?>" selected><?= $selectedProduct['product_name'] ?></option>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="mb-3">
<label class="form-label">Status</label>
<select name="status" class="form-select" required>
    <option value="active" <?= $coupon['status']==='active'?'selected':'' ?>>Active</option>
    <option value="inactive" <?= $coupon['status']==='inactive'?'selected':'' ?>>Inactive</option>
</select>
</div>

<div class="mb-3">
<label class="form-label">Start Date</label>
<input type="date" name="start_date" class="form-control" value="<?= $coupon['start_date'] ?>">
</div>

<div class="mb-3">
<label class="form-label">End Date</label>
<input type="date" name="end_date" class="form-control" value="<?= $coupon['end_date'] ?>">
</div>

<div class="mb-3">
<label class="form-label">Usage Limit</label>
<input type="number" name="usage_limit" class="form-control" value="<?= $coupon['usage_limit'] ?>">
</div>

<button type="submit" class="btn btn-primary">Update Coupon</button>
<a href="?page=coupons" class="btn btn-secondary">Cancel</a>
</form>
</div>

<script>
const scopeSelect = document.getElementById('scopeSelect');
const productDiv = document.getElementById('productDiv');
const catSelect = document.getElementById('catSelect');
const prodSelect = document.getElementById('prodSelect');

scopeSelect.addEventListener('change', ()=>{
    productDiv.style.display = scopeSelect.value==='product' ? 'block' : 'none';
});

// AJAX to load products on category change
catSelect.addEventListener('change', ()=>{
    const cid = catSelect.value;
    prodSelect.innerHTML='<option>Loading...</option>';
    prodSelect.disabled=true;

    if(!cid){
        prodSelect.innerHTML='<option value="">-- Choose Product --</option>';
        return;
    }

    fetch('ajax/get_products_by_category.php?category_id='+encodeURIComponent(cid))
    .then(r=>r.json())
    .then(d=>{
        prodSelect.innerHTML='<option value="">-- Choose Product --</option>';
        if(d.items && d.items.length){
            d.items.forEach(it=>{
                const opt=document.createElement('option');
                opt.value=it.id; opt.textContent=it.name;
                prodSelect.appendChild(opt);
            });
            prodSelect.disabled=false;
        } else {
            prodSelect.innerHTML='<option value="">No products found</option>';
        }
    }).catch(()=> prodSelect.innerHTML='<option value="">Error loading</option>');
});
</script>
</body>
</html>
