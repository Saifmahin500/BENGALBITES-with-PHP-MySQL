<?php
require_once __DIR__ . '/../../config/dbconfig.php';

$database = new Database();
$conn = $database->dbConnection();

$conn->exec("UPDATE contact_message SET is_read = 1 WHERE is_read = 0");

$sql = "SELECT cm.*, 
		CASE WHEN u.id IS NULL THEN 0 ELSE 1 END AS is_registered
		FROM contact_message cm
		LEFT JOIN users u ON u.email = cm.email
		ORDER BY cm.created_at DESC";

$stmt = $conn->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>User Feedback Management</title>

    <!-- Bootstrap 4.6 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
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

        .page-header {
            background: linear-gradient(135deg, var(--brand-color) 0%, var(--brand-light) 100%);
            color: white;
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .feedback-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            border: none;
            overflow: hidden;
        }

        .stats-bar {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .custom-table-thead {
            background: linear-gradient(135deg, var(--brand-color) 0%, var(--brand-dark) 100%);
            color: white;
        }

        .custom-table-thead th {
            border: none;
            font-weight: 600;
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered td {
            border-color: #dee2e6;
            padding: 0.75rem;
            vertical-align: middle;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(52, 133, 167, 0.02);
        }

        .table tbody tr:hover {
            background-color: rgba(52, 133, 167, 0.05);
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

        .btn-outline-brand {
            color: var(--brand-color);
            border-color: var(--brand-color);
        }

        .btn-outline-brand:hover {
            background-color: var(--brand-color);
            border-color: var(--brand-color);
            color: white;
        }

        .badge-brand {
            background-color: var(--brand-color);
            color: white;
        }

        .text-brand {
            color: var(--brand-color);
        }

        .user-info {
            line-height: 1.3;
        }

        .message-cell {
            max-width: 300px;
            word-wrap: break-word;
            white-space: pre-wrap;
            font-size: 0.9rem;
        }

        .reply-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 0.75rem;
        }

        .status-replied {
            background-color: #28a745;
        }

        .status-pending {
            background-color: #ffc107;
        }

        .checkbox-custom {
            transform: scale(1.1);
            accent-color: var(--brand-color);
        }

        .action-buttons {
            min-width: 200px;
        }

        .reply-details {
            background: #f8f9fa;
            border-radius: 5px;
            padding: 0.5rem;
            margin-top: 0.5rem;
            font-size: 0.85rem;
        }

        .delete-btn-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .icon-brand {
            color: var(--brand-color);
        }
    </style>
</head>

<body>
    <!-- Page Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-0">
                        <i class="fas fa-comments mr-2"></i>
                        User Feedback Management
                    </h3>
                    <p class="mb-0 mt-1 opacity-75">Manage and respond to customer feedback messages</p>
                </div>
                <div class="col-md-4 text-md-right">
                    <i class="fas fa-envelope-open-text fa-2x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Feedback Management Card -->
        <div class="card feedback-card">
            <!-- Stats Bar -->
            <div class="stats-bar">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-chart-bar icon-brand mr-2"></i>
                            <h5 class="mb-0 text-dark">Feedback Overview</h5>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-end align-items-center">
                            <span class="badge badge-brand mr-2 px-3 py-2">
                                <i class="fas fa-list-ol mr-1"></i>
                                Total: <?= count($rows) ?>
                            </span>
                            <div class="delete-btn-container">
                                <button id="deleteSelected" class="btn btn-sm btn-danger" disabled>
                                    <i class="fas fa-trash-alt mr-1"></i>
                                    Delete Selected
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped mb-0" id="fbTable">
                    <thead class="custom-table-thead">
                        <tr>
                            <th style="width: 50px;">
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" name="selectAll" id="selectAll" class="checkbox-custom mr-2">
                                    <i class="fas fa-check-square"></i>
                                </div>
                            </th>
                            <th style="width: 60px;">
                                <i class="fas fa-hashtag mr-1"></i>
                                #
                            </th>
                            <th>
                                <i class="fas fa-user mr-1"></i>
                                Name / Email
                            </th>
                            <th>
                                <i class="fas fa-tag mr-1"></i>
                                Subject
                            </th>
                            <th>
                                <i class="fas fa-comment mr-1"></i>
                                Message
                            </th>
                            <th>
                                <i class="fas fa-clock mr-1"></i>
                                Received
                            </th>
                            <th>
                                <i class="fas fa-flag mr-1"></i>
                                Status
                            </th>
                            <th class="action-buttons">
                                <i class="fas fa-reply mr-1"></i>
                                Reply
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $i => $r): ?>
                            <tr data-id="<?= (int)$r['id']; ?>">
                                <td class="text-center">
                                    <input type="checkbox" name="rowChk" class="rowChk checkbox-custom" value="<?= (int)$r['id'] ?>">
                                </td>
                                <td class="text-center font-weight-bold"><?= $i + 1 ?></td>
                                <td>
                                    <div class="user-info">
                                        <div class="font-weight-bold"><?= htmlspecialchars($r['name']) ?></div>
                                        <div class="text-muted small">
                                            <i class="fas fa-envelope mr-1"></i>
                                            <?= htmlspecialchars($r['email']) ?>
                                        </div>
                                        <?php if ((int)$r['is_registered'] === 0): ?>
                                            <div class="text-warning small">
                                                <i class="fas fa-user-times mr-1"></i>
                                                Not Registered
                                            </div>
                                        <?php else: ?>
                                            <div class="text-success small">
                                                <i class="fas fa-user-check mr-1"></i>
                                                Registered User
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if (!empty($r['subject'])): ?>
                                        <span class="badge badge-light"><?= htmlspecialchars($r['subject']) ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">--</span>
                                    <?php endif; ?>
                                </td>
                                <td class="message-cell"><?= nl2br(htmlspecialchars($r['message'])) ?></td>
                                <td class="small text-muted">
                                    <i class="fas fa-calendar mr-1"></i>
                                    <?= date('M d, Y', strtotime($r['created_at'])) ?><br>
                                    <i class="fas fa-clock mr-1"></i>
                                    <?= date('h:i A', strtotime($r['created_at'])) ?>
                                </td>
                                <td>
                                    <?php if ((int)$r['is_replied'] === 1): ?>
                                        <span class="badge status-replied">
                                            <i class="fas fa-check mr-1"></i>
                                            Replied
                                        </span>
                                    <?php else: ?>
                                        <span class="badge status-pending">
                                            <i class="fas fa-clock mr-1"></i>
                                            Pending
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="action-buttons">
                                    <?php if ((int)$r['is_replied'] === 0): ?>
                                        <button class="btn btn-sm btn-brand relpyBtn" data-id="<?= $r['id'] ?>">
                                            <i class="fas fa-reply mr-1"></i>
                                            Reply
                                        </button>
                                        <div class="reply-box mt-2 d-none" id="rb-<?= $r['id'] ?>">
                                            <textarea class="form-control mb-2" rows="3" placeholder="Type your reply..." id="rt-<?= $r['id'] ?>"></textarea>
                                            <button class="btn btn-sm btn-success sendReply" data-id="<?= $r['id'] ?>">
                                                <i class="fas fa-paper-plane mr-1"></i>
                                                Send
                                            </button>
                                            <div class="small text-muted mt-2">
                                                <i class="fas fa-info-circle mr-1"></i>
                                                This will be emailed to the visitor.
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="small text-muted mb-2">
                                            <i class="fas fa-paper-plane mr-1"></i>
                                            Sent: <?= date('M d, Y h:i A', strtotime($r['replied_at'] ?: $r['created_at'])) ?>
                                        </div>
                                        <?php if (!empty($r['reply_text'])): ?>
                                            <details class="reply-details">
                                                <summary class="text-brand" style="cursor: pointer;">
                                                    <i class="fas fa-eye mr-1"></i>
                                                    View Reply
                                                </summary>
                                                <div class="mt-2 p-2 bg-white rounded border small" style="white-space: pre-wrap;">
                                                    <?= nl2br(htmlspecialchars($r['reply_text'])) ?>
                                                </div>
                                            </details>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if (empty($rows)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No feedback messages found</h5>
                    <p class="text-muted">Customer feedback will appear here when received.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        document.addEventListener('click', function(e) {

            if (e.target.classList.contains('relpyBtn')) {
                var id = e.target.getAttribute('data-id');
                document.getElementById('rb-' + id).classList.toggle('d-none');
            }

            if (e.target.classList.contains('sendReply')) {
                var id = e.target.getAttribute('data-id');
                var txt = (document.getElementById('rt-' + id).value || '').trim();

                if (!txt) {
                    alert('Please type your reply');
                    return;
                }

                fetch('ajax/send_reply.php', {

                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    credentials: 'same-origin',
                    body: 'id=' + encodeURIComponent(id) + '&reply=' + encodeURIComponent(txt)
                }).then(r => r.json()).then(d => {

                    if (d.ok) {
                        alert('Reply Sent!');
                        location.reload();
                    } else {
                        alert(d.error || 'Failed to send');
                    }
                }).catch(() => alert('Unexpected Error'));
            }

        });

        (function() {

            var selectAll = document.getElementById('selectAll');
            var table = document.getElementById('fbTable');
            var deleteBtn = document.getElementById('deleteSelected');

            function updateDeleteBtnState() {
                var anyChecked = table.querySelectorAll('tbody .rowChk:checked').length > 0;
                deleteBtn.disabled = !anyChecked;
            }

            if (selectAll) {
                selectAll.addEventListener('change', function() {

                    var rows = table.querySelectorAll('tbody .rowChk');
                    rows.forEach(function(chk) {

                        chk.checked = selectAll.checked;
                    });
                    updateDeleteBtnState();
                });
            }

            table.addEventListener('change', function(e) {

                if (e.target.classList.contains('rowChk')) {
                    var all = table.querySelectorAll('tbody .rowChk').length;
                    var sel = table.querySelectorAll('tbody .rowChk:checked').length;
                    if (selectAll) selectAll.checked = (all > 0 && sel === all);
                    updateDeleteBtnState();
                }
            });

            deleteBtn.addEventListener('click', function() {

                var ids = Array.from(table.querySelectorAll('tbody .rowChk:checked')).map(function(chk) {

                    return chk.value;
                });

                if (ids.length === 0)

                {
                    return;
                }

                if (!confirm('Delete selected ' + ids.length + ' message(s)? This action cannot be undone.')) {
                    return;
                }

                fetch('ajax/delete_feedback.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        ids: ids
                    })

                }).then(r => r.json()).then(d => {
                    if (d.ok) {
                        alert("Deleted: " + d.deleted + ' message(s).');
                        location.reload();
                    } else {
                        alert(d.error || 'Delete failed');
                    }
                }).catch(() => alert('Unexpected Error'));

            });
        })();
    </script>
</body>

</html>