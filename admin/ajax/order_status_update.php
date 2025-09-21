<?php
if(session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json; charset=utf-8');
if(!isset($_SESSION['admin_logged_in'])) { http_response_code(403); exit('Forbidden');}

require_once __DIR__ .'/../dbConfig.php';

$gid = trim($_POST['global_order_id'] ?? '');
$st = trim($_POST['status'] ?? '');

$allowed = ['pending','delivered','completed','canceled'];
if($gid === '' || !in_array($st, $allowed, true))
{
	echo json_encode(['ok' => false, 'msg' =>'Invalid Input']);
	exit;
}

try 
{
	$q = $DB_con->prepare("UPDATE orders SET status = ? WHERE global_order_id = ?");
	$q->execute([$st, $gid]);

	echo json_encode(['ok' => true]);
} 
catch (Throwable $e) 
{
	echo json_encode(['ok' => false, 'msg'=> 'DB Error']);
}

?>