<?php
// Database connection
include('dbConfig.php');


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid request!");
}

$id = (int)$_GET['id'];


$stmt = $DB_con->prepare("DELETE FROM coupons WHERE id = ?");
$stmt->execute([$id]);

if ($stmt->execute()) {
    
    header("Location: ?page=coupons");
    exit;
} else {
    echo "Error deleting coupon: " . $stmt->error;
}
