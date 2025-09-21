<?php
if(session_status() === PHP_SESSION_NONE) session_start();
header('Content-Type: application/json; charset=utf-8');

if(!isset($_SESSION['admin_logged_in']))
{
	echo json_encode(['ok' => false, 'msg' => 'Unauthorized']);
	exit;
}

require_once __DIR__ .'/../dbConfig.php';

$mode = $_POST['mode'] ?? '';

try 
{
	if($mode === 'all')
	{
		$code = trim($_POST['code'] ?? '');
		$disc = (float)($_POST['discount_percent'] ?? 0);
		$status = ($_POST['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';
		$sd = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
		$ed = !empty($_POST['end_date']) ? $_POST['end_date'] : null;

		$usage_limit = !empty($_POST['usage_limit']) ? (int)$_POST['usage_limit'] : null;

		if($code === '' || $disc <= 0) throw new Exception('Invalid coupon data');

		$ins = $DB_con->prepare("INSERT INTO coupons (code, discount_percent, scope, status, start_date, end_date, usage_limit, usage_count) VALUES (?,?,'all',?,?,?,?,0)");
		$ins->execute([$code, $disc, $status, $sd, $ed, $usage_limit]);

		echo json_encode(['ok' => true, 'msg' => 'Coupon created for All products']);
	}

	elseif($mode === 'selected')
	{
		$pid = (int)($_POST['product_id'] ?? 0);
		$code = trim($_POST['code'] ?? '');
		$disc = (float)($_POST['discount_percent'] ?? 0);
		$status = ($_POST['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';
		$sd = !empty($_POST['start_date']) ? $_POST['start_date'] : null;
		$ed = !empty($_POST['end_date']) ? $_POST['end_date'] : null;
		
		$usage_limit = !empty($_POST['usage_limit']) ? (int)$_POST['usage_limit'] : null;

		if($pid <= 0 || $code === '' || $disc <= 0) throw new Exception('Invalid selected coupon data');

		//Create Coupon

		$ins = $DB_con->prepare("INSERT INTO coupons (code, discount_percent, scope, status, start_date, end_date, usage_limit, usage_count) VALUES (?,?,'product',?,?,?,?,0)");

		$ins->execute([$code, $disc, $status, $sd, $ed, $usage_limit]);

		$couponId = (int)$DB_con->lastInsertId();

		$mp = $DB_con->prepare("INSERT INTO coupon_products(coupon_id, product_id) VALUES (?, ?)");

		$mp->execute([$couponId, $pid]);

		echo json_encode(['ok' => true, 'msg' => 'Coupon created for selected product']);
		exit;
	}

	else
	{
		echo json_encode(['ok' => false, 'msg' => 'Invalid Mode!']);
		exit;
	}
} 
catch (Exception $e) 
{
	echo json_encode(['ok' => false, 'msg' => $e->getMessage()]);
	exit;
}

?>