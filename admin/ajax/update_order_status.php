<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(403);
    exit('Forbidden');
}

require_once __DIR__ . '/../dbConfig.php';

if (!isset($_POST['global_order_id'], $_POST['status'])) exit("Invalid request");

$gid = $_POST['global_order_id'];
$status = $_POST['status'];

try {
    $DB_con->beginTransaction();

    // Fetch orders
    $stmt = $DB_con->prepare("SELECT id, product_id, quantity, status FROM orders WHERE global_order_id = :gid");
    $stmt->execute([':gid' => $gid]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$orders) throw new Exception("Order not found");

    $currentStatus = $orders[0]['status'];

    // Update order status
    $stmt2 = $DB_con->prepare("UPDATE orders SET status=:status WHERE global_order_id=:gid");
    $stmt2->execute([':status' => $status, ':gid' => $gid]);

    // Deduct stock only if changed to completed
    if ($status === 'completed' && $currentStatus !== 'completed') {
        foreach ($orders as $order) {
            $pid = $order['product_id'];
            $qty = $order['quantity'];

            // Update products table
            $upd = $DB_con->prepare("UPDATE products SET stock_amount = stock_amount - :qty WHERE id=:pid");
            $upd->execute([':qty' => $qty, ':pid' => $pid]);

            // Insert inventory log
            $log = $DB_con->prepare("INSERT INTO inventory (product_id, change_type, quantity, remarks) VALUES (:pid,'out',:qty,'Order Completed')");
            $log->execute([':pid' => $pid, ':qty' => $qty]);
        }
    }

    $DB_con->commit();
    echo "✅ Order status updated & stock deducted successfully!";
} catch (Throwable $e) {
    $DB_con->rollBack();
    echo "❌ Error: " . $e->getMessage();
}
