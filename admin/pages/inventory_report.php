<?php
require_once 'dbConfig.php';
$query = "SELECT i.*, p.product_name FROM inventory i JOIN products p ON i.product_id = p.id ORDER BY i.created_at DESC";
$stmt = $DB_con->query($query);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --brand-color: #3485A7;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f0f5 100%);
            min-height: 100vh;
        }

        .report-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            background: linear-gradient(135deg, var(--brand-color) 0%, #2a6a8a 100%);
            color: white;
            padding: 30px 35px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(52, 133, 167, 0.2);
        }

        .page-header h4 {
            margin: 0;
            font-weight: 700;
            display: flex;
            align-items: center;
            font-size: 1.8rem;
        }

        .page-header h4 i {
            margin-right: 15px;
            font-size: 1.4em;
        }

        .page-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .stats-row {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .stat-card {
            flex: 1;
            min-width: 200px;
            background: white;
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(52, 133, 167, 0.08);
            display: flex;
            align-items: center;
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(52, 133, 167, 0.12);
        }

        .stat-icon {
            width: 55px;
            height: 55px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            margin-right: 15px;
        }

        .stat-icon.total {
            background: linear-gradient(135deg, var(--brand-color) 0%, #2a6a8a 100%);
            color: white;
        }

        .stat-icon.in {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            color: white;
        }

        .stat-icon.out {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .stat-info h6 {
            margin: 0;
            color: #7f8c8d;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: #2c3e50;
            margin-top: 5px;
        }

        .table-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(52, 133, 167, 0.08);
            overflow: hidden;
        }

        .table-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 20px 25px;
            border-bottom: 2px solid var(--brand-color);
        }

        .table-header h5 {
            margin: 0;
            color: var(--brand-color);
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .table-header h5 i {
            margin-right: 10px;
        }

        .table-responsive {
            padding: 0;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: var(--brand-color);
            color: white;
            font-weight: 600;
            border: none;
            padding: 18px 20px;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            color: #495057;
            border-bottom: 1px solid #f1f3f5;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: #f8fbfd;
            transform: scale(1.01);
        }

        .badge {
            padding: 7px 15px;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
        }

        .badge i {
            margin-right: 5px;
        }

        .badge-success {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            color: white;
        }

        .badge-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
        }

        .product-name {
            font-weight: 600;
            color: #2c3e50;
        }

        .quantity {
            font-weight: 700;
            color: var(--brand-color);
            font-size: 1.1rem;
        }

        .date-time {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .date-time i {
            margin-right: 5px;
            color: var(--brand-color);
        }

        .remarks-text {
            color: #7f8c8d;
            font-style: italic;
        }

        .no-remarks {
            color: #bdc3c7;
        }

        /* Sidebar fix */
.sidebar {
    width: 250px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
}

/* Main content fix */
.report-container {
    margin-left: 120px; /* Sidebar width */
    padding: 20px;
    max-width: calc(100% - 250px);
}

        @media (max-width: 768px) {
            .page-header {
                padding: 25px 20px;
            }

            .page-header h4 {
                font-size: 1.5rem;
            }

            .stats-row {
                flex-direction: column;
            }

            .stat-card {
                min-width: 100%;
            }

            .table-responsive {
                overflow-x: auto;
            }

            .table thead th,
            .table tbody td {
                padding: 12px 15px;
                font-size: 0.85rem;
            }
        }

        .export-btn {
            background: white;
            color: var(--brand-color);
            border: 2px solid var(--brand-color);
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-left: 15px;
        }

        .export-btn:hover {
            background: var(--brand-color);
            color: white;
        }
    </style>
</head>

<body>
    <div class="container report-container">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h4><i class="fas fa-clipboard-list"></i> Inventory Report</h4>
                    <p><i class="far fa-calendar-alt mr-2"></i>Complete inventory transaction history</p>
                </div>
            </div>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon total">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="stat-info">
                    <h6>Total Transactions</h6>
                    <div class="stat-number"><?= count($logs) ?></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon in">
                    <i class="fas fa-arrow-circle-up"></i>
                </div>
                <div class="stat-info">
                    <h6>Stock In</h6>
                    <div class="stat-number"><?= count(array_filter($logs, function ($l) {
                                                    return $l['change_type'] === 'in';
                                                })) ?></div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon out">
                    <i class="fas fa-arrow-circle-down"></i>
                </div>
                <div class="stat-info">
                    <h6>Stock Out</h6>
                    <div class="stat-number"><?= count(array_filter($logs, function ($l) {
                                                    return $l['change_type'] === 'out';
                                                })) ?></div>
                </div>
            </div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h5><i class="fas fa-list-ul"></i> Transaction History</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th><i class="far fa-calendar-alt mr-2"></i>Date & Time</th>
                            <th><i class="fas fa-box mr-2"></i>Product</th>
                            <th><i class="fas fa-exchange-alt mr-2"></i>Type</th>
                            <th><i class="fas fa-cubes mr-2"></i>Quantity</th>
                            <th><i class="fas fa-comment mr-2"></i>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                            <tr>
                                <td>
                                    <span class="date-time">
                                        <i class="far fa-clock"></i><?= $log['created_at'] ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="product-name"><?= htmlspecialchars($log['product_name']) ?></span>
                                </td>
                                <td>
                                    <?php if ($log['change_type'] === "in"): ?>
                                        <span class="badge badge-success">
                                            <i class="fas fa-arrow-up"></i>IN
                                        </span>
                                    <?php else: ?>
                                        <span class="badge badge-danger">
                                            <i class="fas fa-arrow-down"></i>OUT
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="quantity"><?= $log['quantity'] ?></span>
                                </td>
                                <td>
                                    <?php if (!empty($log['remarks'])): ?>
                                        <span class="remarks-text"><?= htmlspecialchars($log['remarks']) ?></span>
                                    <?php else: ?>
                                        <span class="no-remarks">No remarks</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>