<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <!-- Bootstrap 4.6 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --brand-color: #3485A7;
            --brand-light: #4a9bc7;
            --brand-dark: #2a6b85;
        }

        body {
            background-color: #f8f9fa;
        }

        .main-header {
            background: linear-gradient(135deg, var(--brand-color) 0%, var(--brand-light) 100%);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .filter-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-top: 4px solid var(--brand-color);
        }

        .btn-brand {
            background-color: var(--brand-color);
            border-color: var(--brand-color);
            color: white;
        }

        .btn-brand:hover {
            background-color: var(--brand-dark);
            border-color: var(--brand-dark);
            color: white;
        }

        .form-control:focus {
            border-color: var(--brand-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 133, 167, 0.25);
        }

        .select-focus:focus {
            border-color: var(--brand-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 133, 167, 0.25);
        }

        .data-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            min-height: 400px;
        }

        .icon-brand {
            color: var(--brand-color);
        }

        /* Custom table styling */
        #salesData table {
            border-collapse: collapse;
            width: 100%;
        }

        #salesData th,
        #salesData td {
            border: 1px solid #dee2e6;
            padding: 12px;
        }

        #salesData th {
            background: var(--brand-color);
            color: white;
            font-weight: 600;
        }

        #salesData tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        #salesData tr:hover {
            background-color: #e9ecef;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            padding: 3rem;
            color: var(--brand-color);
        }
    </style>
</head>

<body>
    <!-- Header Section -->
    <div class="main-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-0">
                        <i class="fas fa-chart-line mr-3"></i>
                        Sales Report
                    </h1>
                    <p class="mb-0 mt-2 opacity-75">Comprehensive sales data analysis and reporting</p>
                </div>
                <div class="col-md-4 text-md-right">
                    <div class="d-flex align-items-center justify-content-md-end">
                        <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card filter-card">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="card-title text-dark mb-0">
                            <i class="fas fa-filter icon-brand mr-2"></i>
                            Filter Options
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="filterForm">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="start_date" class="form-label font-weight-bold">
                                        <i class="fas fa-calendar-check icon-brand mr-1"></i>
                                        Start Date
                                    </label>
                                    <input type="date" class="form-control" name="start_date" id="start_date">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="end_date" class="form-label font-weight-bold">
                                        <i class="fas fa-calendar-times icon-brand mr-1"></i>
                                        End Date
                                    </label>
                                    <input type="date" class="form-control" name="end_date" id="end_date">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="month" class="form-label font-weight-bold">
                                        <i class="fas fa-calendar-alt icon-brand mr-1"></i>
                                        Month
                                    </label>
                                    <select name="month" id="month" class="form-control select-focus">
                                        <option value="">Select Month</option>
                                        <?php for ($m = 1; $m <= 12; $m++): ?>
                                            <option value="<?= $m ?>"><?= date('F', mktime(0, 0, 0, $m, 1)) ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="year" class="form-label font-weight-bold">
                                        <i class="fas fa-calendar icon-brand mr-1"></i>
                                        Year
                                    </label>
                                    <input type="number" class="form-control" name="year" id="year" min="2000" max="2099" value="<?= date('Y') ?>">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label font-weight-bold text-white">Action</label>
                                    <div>
                                        <button type="submit" class="btn btn-brand btn-block">
                                            <i class="fas fa-search mr-2"></i>
                                            Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Section -->
        <div class="row">
            <div class="col-12">
                <div class="card data-card">
                    <div class="card-header bg-transparent border-0">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="card-title text-dark mb-0">
                                    <i class="fas fa-table icon-brand mr-2"></i>
                                    Sales Data
                                </h5>
                            </div>
                            <!-- <div class="col-md-4 text-md-right">
                                <button id="exportCSV" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-download mr-1"></i>
                                    Export CSV
                                </button>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Loading Spinner -->
                        <div class="loading-spinner" id="loadingSpinner">
                            <div class="spinner-border icon-brand" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-3">Loading sales data...</p>
                        </div>

                        <!-- Sales Data Container -->
                        <div id="salesData">
                            <!-- এখানে AJAX টেবিল লোড হবে -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function loadData(params = "") {
            // Show loading spinner
            $("#loadingSpinner").show();
            $("#salesData").hide();

            $.get("pages/sales_report_ajax.php" + params, function(data) {
                $("#salesData").html(data).show();
                $("#loadingSpinner").hide();
            }).fail(function() {
                $("#salesData").html('<div class="alert alert-danger"><i class="fas fa-exclamation-triangle mr-2"></i>Error loading data. Please try again.</div>').show();
                $("#loadingSpinner").hide();
            });
        }

        // প্রথমবার লোড হলে সব ডেটা দেখাবে
        loadData();

        $("#filterForm").on("submit", function(e) {
            e.preventDefault();
            const params = "?" + $(this).serialize();
            loadData(params);
        });

        $("#exportCSV").on("click", function(e) {
            e.preventDefault();
            const params = "?" + $("#filterForm").serialize() + "&export=csv";
            window.location.href = "sales_report_ajax.php" + params;
        });
    </script>
</body>

</html>