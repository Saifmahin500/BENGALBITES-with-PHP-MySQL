<?php
require_once 'partials/header.php';
require_once 'partials/navbar.php';
?>

<div class="container my-5">
    <h2 class="text-center mb-5">Our Menu</h2>
    <div class="row">
        <?php include "fetch_products.php"; ?>
    </div>
</div>

<?php require_once 'partials/footer.php'; ?>


