<?php
require_once "dbConfig.php";
//Fetch Products
$stmt = $DB_con->query("SELECT id, product_name, stock_amount FROM products ORDER BY product_name");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$selected_id = $_GET['product_id'] ?? null;
$logs = [];
if ($selected_id) {
    $query = "SELECT i.*, p.product_name FROM inventory i JOIN products p ON i.product_id = p.id WHERE i.product_id = ? ORDER BY i.created_at DESC";
    $stmt2 = $DB_con->prepare($query);
    $stmt2->execute([$selected_id]);
    $logs = $stmt2->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock by Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --brand-color: #3485A7;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f0f5 100%);
            min-height: 100vh;
            /* padding: 40px 0; */
        }

        .stock-container {
            max-width: 1100px;
            margin-left: 120px;
            padding: 20px;
            max-width: calc(100% - 250px);
        }

        .sidebar {
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
        }

        .page-header {
            background: linear-gradient(135deg, var(--brand-color) 0%, #2a6a8a 100%);
            border-radius: 15px;
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(52, 133, 167, 0.08);
        }

        .page-header h4 {
            margin: 0;
            color: white;
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .page-header h4 i {
            margin-right: 12px;
            font-size: 1.3em;
        }

        .filter-card {
            background: white;
            border-radius: 15px;
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 20px rgba(52, 133, 167, 0.08);
        }

        .filter-card label {
            font-weight: 600;
            color: #2c3e50;
            margin-right: 15px;
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }

        .filter-card label i {
            margin-right: 8px;
            color: var(--brand-color);
        }

        .form-control {
            border-radius: 8px;
            border: 2px solid #e1e8ed;
            padding: 5px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--brand-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 133, 167, 0.15);
        }

        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%233485A7' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            padding-right: 40px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--brand-color) 0%, #2a6a8a 100%);
            border: none;
            border-radius: 8px;
            padding: 10px 30px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 133, 167, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 133, 167, 0.35);
            background: linear-gradient(135deg, #2a6a8a 0%, var(--brand-color) 100%);
        }

        .history-header {
            background: linear-gradient(135deg, var(--brand-color) 0%, #2a6a8a 100%);
            color: white;
            padding: 20px 25px;
            border-radius: 12px 12px 0 0;
            margin-bottom: 0;
        }

        .history-header h5 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .history-header h5 i {
            margin-right: 10px;
        }

        .table-container {
            background: white;
            border-radius: 0 0 15px 15px;
            box-shadow: 0 5px 20px rgba(52, 133, 167, 0.08);
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f8f9fa;
            color: #2c3e50;
            font-weight: 600;
            border: none;
            padding: 15px 20px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table tbody td {
            padding: 15px 20px;
            vertical-align: middle;
            color: #495057;
            border-bottom: 1px solid #f1f3f5;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover {
            background: #f8fbfd;
        }

        .badge {
            padding: 6px 14px;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 6px;
        }

        .badge-success {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            color: white;
        }

        .badge-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 20px 25px;
            box-shadow: 0 5px 20px rgba(52, 133, 167, 0.08);
        }

        .alert-info {
            background: linear-gradient(135deg, #e8f4f8 0%, #d6eaf8 100%);
            color: #1f618d;
            display: flex;
            align-items: center;
        }

        .alert-info i {
            font-size: 1.5em;
            margin-right: 15px;
        }

        .form-inline {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        @media (max-width: 768px) {
            .form-inline {
                flex-direction: column;
                align-items: stretch;
            }

            .form-inline .form-control,
            .form-inline .btn {
                width: 100%;
                margin: 0;
            }

            .table-container {
                overflow-x: auto;
            }

            .page-header,
            .filter-card {
                padding: 20px;
            }
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(52, 133, 167, 0.08);
        }

        .empty-state i {
            font-size: 4em;
            color: var(--brand-color);
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h5 {
            color: #7f8c8d;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="container stock-container">
        <div class="page-header">
            <h4><i class="fas fa-chart-line"></i> Stock History by Product</h4>
        </div>

        <div class="filter-card">
            <form method="get" class="form-inline">
                <input type="hidden" name="page" value="stock_by_products">
                <label><i class="fas fa-filter"></i> Select Product:</label>
                <select name="product_id" class="form-control mr-2" required>
                    <option value="">-- Choose a product --</option>
                    <?php foreach ($products as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= ($selected_id == $p['id']) ? 'selected' : '' ?>>
                            <?= $p['product_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search mr-2"></i>View History
                </button>
            </form>
        </div>

        <?php if ($selected_id && count($logs) > 0): ?>
            <div class="history-header">
                <h5><i class="fas fa-history"></i> Stock History for: <?= htmlspecialchars($logs[0]['product_name']) ?></h5>
            </div>
            <div class="table-container">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><i class="far fa-calendar-alt mr-2"></i>Date & Time</th>
                            <th><i class="fas fa-exchange-alt mr-2"></i>Change Type</th>
                            <th><i class="fas fa-cubes mr-2"></i>Quantity</th>
                            <th><i class="fas fa-comment mr-2"></i>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td><i class="far fa-clock mr-2" style="color: var(--brand-color);"></i><?= $log['created_at'] ?></td>
                                <td>
                                    <?php if ($log['change_type'] === 'in'): ?>
                                        <span class="badge badge-success"><i class="fas fa-arrow-up mr-1"></i>IN</span>
                                    <?php else: ?>
                                        <span class="badge badge-danger"><i class="fas fa-arrow-down mr-1"></i>OUT</span>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= $log['quantity'] ?></strong></td>
                                <td><?= htmlspecialchars($log['remarks']) ?: '<span style="color: #bdc3c7;">No remarks</span>' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($selected_id): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i>
                <span>No stock history found for this product.</span>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-box-open"></i>
                <h5>Select a product to view its stock history</h5>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>