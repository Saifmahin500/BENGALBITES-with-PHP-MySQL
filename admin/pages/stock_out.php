<?php

error_reporting(0);
require_once 'dbConfig.php';
//Fetch Products
$stmt = $DB_con->query("SELECT id, product_name, stock_amount FROM products ORDER BY product_name");

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $remarks = $_POST['remarks'];

    //Update product stock

    $update = $DB_con->prepare("UPDATE products SET stock_amount = stock_amount - ? WHERE id = ? ");
    $update->execute([$quantity, $product_id]);

    //Insert into inventory

    $log = $DB_con->prepare("INSERT INTO inventory (product_id, change_type, quantity, remarks) VALUES (?,'out',?,?)");

    $log->execute([$product_id, $quantity, $remarks]);

    echo "<div class='alert alert-success'>Stock Reduced Successfully</div>";

    header('location: ?page=products');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Out</title>
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

        .stock-container {
            max-width: 650px;
            margin: 0 auto;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(52, 133, 167, 0.1);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--brand-color) 0%, #2a6a8a 100%);
            color: white;
            padding: 25px 30px;
            border: none;
        }

        .card-header h4 {
            margin: 0;
            font-weight: 600;
            display: flex;
            align-items: center;
        }

        .card-header h4 i {
            margin-right: 12px;
            font-size: 1.3em;
        }

        .card-body {
            padding: 35px;
            background: white;
        }

        .form-group label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-control,
        .form-control:focus {
            border-radius: 8px;
            border: 2px solid #e1e8ed;
            padding: 5px 15px;
            font-size: 0.95rem;
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
            padding: 12px 35px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 133, 167, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 133, 167, 0.4);
            background: linear-gradient(135deg, #2a6a8a 0%, var(--brand-color) 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .input-icon {
            position: relative;
        }

        .input-icon i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--brand-color);
        }

        .input-icon .form-control {
            padding-left: 45px;
        }

        .form-text {
            color: #7f8c8d;
            font-size: 0.85rem;
            margin-top: 5px;
        }

        @media (max-width: 576px) {
            .card-body {
                padding: 25px 20px;
            }

            .card-header {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container stock-container">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-arrow-circle-down"></i> Stock Out</h4>
            </div>
            <div class="card-body">
                <!-- <div class="warning-badge">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Reducing stock will decrease the product quantity</span>
                </div> -->

                <form method="POST">
                    <div class="form-group">
                        <label><i class="fas fa-tag" style="color: var(--out-color); margin-right: 5px;"></i> Select Product</label>
                        <select name="product_id" class="form-control" required>
                            <option value="">-- Select a product --</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= $p['product_name'] ?> (Current: <?= $p['stock_amount'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text">Choose the product to reduce stock</small>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-sort-numeric-down" style="color: var(--out-color); margin-right: 5px;"></i> Quantity</label>
                        <div class="input-icon">
                            <i class="fas fa-minus-circle"></i>
                            <input type="number" name="quantity" class="form-control" placeholder="Enter quantity" required>
                        </div>
                        <small class="form-text">Enter the number of items to remove</small>
                    </div>

                    <div class="form-group">
                        <label><i class="fas fa-sticky-note" style="color: var(--out-color); margin-right: 5px;"></i> Remarks</label>
                        <div class="input-icon">
                            <i class="fas fa-comment-alt"></i>
                            <input type="text" name="remarks" class="form-control" placeholder="Optional notes">
                        </div>
                        <small class="form-text">Add any additional notes (optional)</small>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-minus-circle mr-2"></i>Reduce Stock
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>