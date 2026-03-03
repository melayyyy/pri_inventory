<?php
// pages/dashboard.php

// Ensure user is logged in
if (!$obj->is_login()) {
    redirect("login.php");
}

$analyticsError = null;
$stats = [
    'sales_month' => 0,
    'purchase_month' => 0,
    'due_sales' => 0,
    'due_purchase' => 0,
    'low_stock_count' => 0,
    'total_products' => 0
];

$recent_sales = [];
$low_stock_items = [];
$top_products = [];
$chart_data = [
    'months' => [],
    'sales' => [],
    'purchases' => [],
    'stock_status' => [0, 0, 0] // [Healthy, Low, Out]
];

// Date ranges for current month
$start_month = date('Y-m-01');
$end_month = date('Y-m-t');

try {
    // 1. Sales this month
    $sql = "SELECT SUM(net_total) as total FROM invoice WHERE order_date >= :start_date AND order_date <= :end_date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':start_date', $start_month);
    $stmt->bindValue(':end_date', $end_month);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['sales_month'] = $row['total'] ?? 0;

    // 2. Purchases this month
    $sql = "SELECT SUM(purchase_net_total) as total FROM purchase_products WHERE purchase_date >= :start_date AND purchase_date <= :end_date";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':start_date', $start_month);
    $stmt->bindValue(':end_date', $end_month);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['purchase_month'] = $row['total'] ?? 0;

    // 3. Due Sales (Total)
    $sql = "SELECT SUM(due_amount) as total FROM invoice";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['due_sales'] = $row['total'] ?? 0;

    // 4. Due Purchases (Total)
    $sql = "SELECT SUM(purchase_due_bill) as total FROM purchase_products";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['due_purchase'] = $row['total'] ?? 0;

    // 5. Low Stock & Total Products
    $sql = "SELECT COUNT(*) as total FROM products WHERE quantity <= alert_quanttity";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['low_stock_count'] = $row['total'] ?? 0;

    $sql = "SELECT COUNT(*) as total FROM products";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stats['total_products'] = $row['total'] ?? 0;

    // 6. Recent Sales
    $sql = "SELECT * FROM invoice ORDER BY order_date DESC LIMIT 5";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $recent_sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 7. Low Stock Items List
    $sql = "SELECT * FROM products WHERE quantity <= alert_quanttity ORDER BY quantity ASC LIMIT 5";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $low_stock_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 8. Top Selling Products
    $sql = "SELECT product_name, SUM(quantity) as qty FROM invoice_details GROUP BY product_name ORDER BY qty DESC LIMIT 5";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $top_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 9. Chart Data: Monthly Trends (Last 6 Months)
    // Initialize last 6 months
    for ($i = 5; $i >= 0; $i--) {
        $date = date('Y-m', strtotime("-$i months"));
        $chart_data['months'][] = date('M Y', strtotime("-$i months"));
        $chart_data['sales'][$date] = 0;
        $chart_data['purchases'][$date] = 0;
    }

    // Fetch Sales
    $sql = "SELECT strftime('%Y-%m', order_date) as month, SUM(net_total) as total FROM invoice WHERE order_date >= date('now', '-6 months') GROUP BY month";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        if (isset($chart_data['sales'][$r['month']])) {
            $chart_data['sales'][$r['month']] = $r['total'];
        }
    }

    // Fetch Purchases
    $sql = "SELECT strftime('%Y-%m', purchase_date) as month, SUM(purchase_net_total) as total FROM purchase_products WHERE purchase_date >= date('now', '-6 months') GROUP BY month";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        if (isset($chart_data['purchases'][$r['month']])) {
            $chart_data['purchases'][$r['month']] = $r['total'];
        }
    }

    // 10. Chart Data: Stock Status
    // Healthy (> alert), Low (<= alert & > 0), Out (= 0)
    $sql = "SELECT 
            SUM(CASE WHEN quantity > alert_quanttity THEN 1 ELSE 0 END) as healthy,
            SUM(CASE WHEN quantity <= alert_quanttity AND quantity > 0 THEN 1 ELSE 0 END) as low,
            SUM(CASE WHEN quantity = 0 THEN 1 ELSE 0 END) as out_of_stock
            FROM products";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $stock_row = $stmt->fetch(PDO::FETCH_ASSOC);
    $chart_data['stock_status'] = [
        $stock_row['healthy'] ?? 0,
        $stock_row['low'] ?? 0,
        $stock_row['out_of_stock'] ?? 0
    ];

} catch (Exception $e) {
    $analyticsError = "Error loading dashboard data: " . $e->getMessage();
}

?>

<style>
    /* Modern Dashboard Styles */
    .content-wrapper {
        background-color: #f4f6f9;
    }
    .card-modern {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.04);
        transition: transform 0.2s, box-shadow 0.2s;
        background: #fff;
        margin-bottom: 24px;
        overflow: hidden;
    }
    .card-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.08);
    }
    .card-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-right: 16px;
    }
    .bg-light-primary { background: rgba(0,123,255,0.1); color: #007bff; }
    .bg-light-success { background: rgba(40,167,69,0.1); color: #28a745; }
    .bg-light-danger { background: rgba(220,53,69,0.1); color: #dc3545; }
    .bg-light-warning { background: rgba(255,193,7,0.1); color: #ffc107; }
    
    .stat-label {
        color: #6c757d;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 4px;
    }
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #343a40;
    }
    .table-modern th {
        border-top: none;
        background: #f8f9fa;
        color: #495057;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
    }
    .table-modern td {
        vertical-align: middle;
        color: #495057;
    }
    .badge-modern {
        padding: 6px 10px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.75rem;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark" style="font-weight: 700;">Dashboard</h1>
                <p class="text-muted small">Overview of your inventory and sales performance</p>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <?php if ($analyticsError): ?>
            <div class="alert alert-danger shadow-sm rounded-lg">
                <i class="icon fas fa-ban"></i> <?php echo htmlspecialchars($analyticsError); ?>
            </div>
        <?php endif; ?>

        <!-- Summary Cards -->
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card card-modern p-3">
                    <div class="d-flex align-items-center">
                        <div class="card-stat-icon bg-light-primary">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div>
                            <div class="stat-label">Sales (This Month)</div>
                            <div class="stat-value">$<?php echo number_format($stats['sales_month'], 2); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card card-modern p-3">
                    <div class="d-flex align-items-center">
                        <div class="card-stat-icon bg-light-success">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                        <div>
                            <div class="stat-label">Purchases (This Month)</div>
                            <div class="stat-value">$<?php echo number_format($stats['purchase_month'], 2); ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card card-modern p-3">
                    <div class="d-flex align-items-center">
                        <div class="card-stat-icon bg-light-danger">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div>
                            <div class="stat-label">Low Stock Items</div>
                            <div class="stat-value"><?php echo number_format($stats['low_stock_count']); ?> <span class="text-muted" style="font-size: 0.875rem">/ <?php echo $stats['total_products']; ?></span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3">
                <div class="card card-modern p-3">
                    <div class="d-flex align-items-center">
                        <div class="card-stat-icon bg-light-warning">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <div>
                            <div class="stat-label">Due Sales</div>
                            <div class="stat-value">$<?php echo number_format($stats['due_sales'], 2); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-modern">
                    <div class="card-header bg-white border-0 py-3">
                        <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-chart-area mr-2 text-primary"></i> Sales & Purchase Trends</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="trendChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card card-modern">
                    <div class="card-header bg-white border-0 py-3">
                        <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-chart-pie mr-2 text-info"></i> Stock Status</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="stockChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Sales Table -->
            <div class="col-lg-8">
                <div class="card card-modern">
                    <div class="card-header bg-white border-0 py-3">
                        <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-history mr-2 text-primary"></i> Recent Sales</h3>
                        <div class="card-tools">
                            <a href="index.php?page=sell_list" class="btn btn-sm btn-light">View All</a>
                        </div>
                    </div>
                    <div class="card-body p-0 table-responsive">
                        <table class="table table-modern table-striped table-hover m-0">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($recent_sales)): ?>
                                    <tr><td colspan="5" class="text-center text-muted py-4">No recent sales found.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($recent_sales as $sale): ?>
                                    <tr>
                                        <td><a href="#" class="text-primary font-weight-bold"><?php echo htmlspecialchars($sale['invoice_number']); ?></a></td>
                                        <td><?php echo htmlspecialchars($sale['customer_name']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($sale['order_date'])); ?></td>
                                        <td>$<?php echo number_format($sale['net_total'], 2); ?></td>
                                        <td>
                                            <?php if ($sale['due_amount'] > 0): ?>
                                                <span class="badge badge-modern badge-warning">Partial</span>
                                            <?php else: ?>
                                                <span class="badge badge-modern badge-success">Paid</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Top Products -->
            <div class="col-lg-4">
                <div class="card card-modern">
                    <div class="card-header bg-white border-0 py-3">
                        <h3 class="card-title font-weight-bold text-dark"><i class="fas fa-trophy mr-2 text-warning"></i> Top Products</h3>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php if (empty($top_products)): ?>
                                <li class="list-group-item text-center text-muted">No sales data yet.</li>
                            <?php else: ?>
                                <?php foreach ($top_products as $idx => $prod): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <span class="badge badge-light mr-2">#<?php echo $idx + 1; ?></span>
                                        <?php echo htmlspecialchars($prod['product_name']); ?>
                                    </div>
                                    <span class="badge badge-primary badge-pill"><?php echo $prod['qty']; ?> sold</span>
                                </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>

                <!-- Low Stock Alert -->
                <div class="card card-modern mt-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h3 class="card-title font-weight-bold text-danger"><i class="fas fa-exclamation-triangle mr-2"></i> Low Stock Alert</h3>
                    </div>
                    <div class="card-body p-0">
                         <ul class="list-group list-group-flush">
                            <?php if (empty($low_stock_items)): ?>
                                <li class="list-group-item text-center text-muted text-success"><i class="fas fa-check-circle mr-1"></i> All stock levels healthy.</li>
                            <?php else: ?>
                                <?php foreach ($low_stock_items as $item): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo htmlspecialchars($item['product_name']); ?>
                                    <span class="badge badge-danger"><?php echo $item['quantity']; ?> left</span>
                                </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Chart Initialization -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Trend Chart
    var trendCtx = document.getElementById('trendChart').getContext('2d');
    var trendChart = new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($chart_data['months']); ?>,
            datasets: [
                {
                    label: 'Sales',
                    backgroundColor: 'rgba(0,123,255,0.1)',
                    borderColor: '#007bff',
                    data: <?php echo json_encode(array_values($chart_data['sales'])); ?>,
                    fill: true
                },
                {
                    label: 'Purchases',
                    backgroundColor: 'rgba(40,167,69,0.1)',
                    borderColor: '#28a745',
                    data: <?php echo json_encode(array_values($chart_data['purchases'])); ?>,
                    fill: true
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Stock Chart
    var stockCtx = document.getElementById('stockChart').getContext('2d');
    var stockChart = new Chart(stockCtx, {
        type: 'doughnut',
        data: {
            labels: ['Healthy', 'Low Stock', 'Out of Stock'],
            datasets: [{
                data: <?php echo json_encode($chart_data['stock_status']); ?>,
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});
</script>
