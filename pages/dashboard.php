<?php
if (!$Ouser->is_login()) {
    redirect("login.php");
}

$analyticsError = null;

$kpi = [
    'sales_month' => 0.0,
    'purchase_month' => 0.0,
    'expense_month' => 0.0,
    'profit_month' => 0.0,
    'sales_due_total' => 0.0,
    'purchase_due_total' => 0.0,
    'collection_rate_month' => 0.0,
    'inventory_health' => 100.0,
    'low_stock_count' => 0,
    'total_products' => 0,
];

$chart = [
    'months' => [],
    'sales' => [],
    'purchases' => [],
    'expenses' => [],
    'stock_status' => [0, 0, 0],
    'payment_labels' => [],
    'payment_values' => [],
    'top_product_labels' => [],
    'top_product_values' => [],
    'category_labels' => [],
    'category_values' => [],
];

$recentSales = [];
$lowStockItems = [];

$officeSuppliesSummary = [
    'total_items' => 0,
    'total_stock_units' => 0,
    'estimated_stock_value' => 0.0,
];

$monthKeys = [];
for ($i = 5; $i >= 0; $i--) {
    $date = new DateTime("first day of -{$i} month");
    $monthKey = $date->format('Y-m');
    $monthKeys[] = $monthKey;
    $chart['months'][] = $date->format('M Y');
    $chart['sales'][$monthKey] = 0.0;
    $chart['purchases'][$monthKey] = 0.0;
    $chart['expenses'][$monthKey] = 0.0;
}

$focusMonthLabel = date('M Y');

try {
    $queryScalar = function ($sql, $params = [], $field = 'total') use ($pdo) {
        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) ($row[$field] ?? 0);
    };

    $fillMonthlySeries = function ($sql, &$targetArray, $params = []) use ($pdo) {
        $stmt = $pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row) {
            $month = (string) ($row['month_key'] ?? '');
            if ($month !== '' && array_key_exists($month, $targetArray)) {
                $targetArray[$month] = (float) ($row['total'] ?? 0);
            }
        }
    };

    // Use latest activity month so analytics remain visible for historical datasets.
    $anchorDate = new DateTime('now');
    $stmt = $pdo->prepare(
        "SELECT MAX(dt) AS latest_date FROM (
            SELECT MAX(order_date) AS dt FROM invoice
            UNION ALL
            SELECT MAX(purchase_date) AS dt FROM purchase_products
            UNION ALL
            SELECT MAX(ex_date) AS dt FROM expense
        ) src"
    );
    $stmt->execute();
    $latestDateRow = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    $latestDate = (string) ($latestDateRow['latest_date'] ?? '');
    if ($latestDate !== '' && $latestDate !== '0000-00-00') {
        $parsedLatest = DateTime::createFromFormat('Y-m-d', $latestDate);
        if ($parsedLatest instanceof DateTime) {
            $anchorDate = $parsedLatest;
        }
    }

    $monthKeys = [];
    $chart['months'] = [];
    $chart['sales'] = [];
    $chart['purchases'] = [];
    $chart['expenses'] = [];
    for ($i = 5; $i >= 0; $i--) {
        $monthDate = (clone $anchorDate)->modify("first day of -{$i} month");
        $monthKey = $monthDate->format('Y-m');
        $monthKeys[] = $monthKey;
        $chart['months'][] = $monthDate->format('M Y');
        $chart['sales'][$monthKey] = 0.0;
        $chart['purchases'][$monthKey] = 0.0;
        $chart['expenses'][$monthKey] = 0.0;
    }

    $rangeStart = (clone $anchorDate)->modify('first day of -5 month')->format('Y-m-01');
    $rangeEnd = (clone $anchorDate)->modify('last day of this month')->format('Y-m-d');
    $currentMonthStart = (clone $anchorDate)->modify('first day of this month')->format('Y-m-01');
    $currentMonthEnd = (clone $anchorDate)->modify('last day of this month')->format('Y-m-d');
    $currentMonthKey = (clone $anchorDate)->modify('first day of this month')->format('Y-m');
    $focusMonthLabel = (clone $anchorDate)->format('M Y');

    $fillMonthlySeries(
        "SELECT strftime('%Y-%m', order_date) AS month_key, SUM(net_total) AS total
         FROM invoice
         WHERE order_date >= :range_start AND order_date <= :range_end
         GROUP BY month_key",
        $chart['sales'],
        [':range_start' => $rangeStart, ':range_end' => $rangeEnd]
    );

    $fillMonthlySeries(
        "SELECT strftime('%Y-%m', purchase_date) AS month_key, SUM(purchase_net_total) AS total
         FROM purchase_products
         WHERE purchase_date >= :range_start AND purchase_date <= :range_end
         GROUP BY month_key",
        $chart['purchases'],
        [':range_start' => $rangeStart, ':range_end' => $rangeEnd]
    );

    $fillMonthlySeries(
        "SELECT strftime('%Y-%m', ex_date) AS month_key, SUM(amount) AS total
         FROM expense
         WHERE ex_date >= :range_start AND ex_date <= :range_end
         GROUP BY month_key",
        $chart['expenses'],
        [':range_start' => $rangeStart, ':range_end' => $rangeEnd]
    );

    $kpi['sales_month'] = (float) ($chart['sales'][$currentMonthKey] ?? 0);
    $kpi['purchase_month'] = (float) ($chart['purchases'][$currentMonthKey] ?? 0);
    $kpi['expense_month'] = (float) ($chart['expenses'][$currentMonthKey] ?? 0);
    $kpi['profit_month'] = $kpi['sales_month'] - $kpi['purchase_month'] - $kpi['expense_month'];

    $salesPaidMonth = $queryScalar(
        "SELECT SUM(paid_amount) AS total
         FROM invoice
         WHERE order_date >= :start_date AND order_date <= :end_date",
        [':start_date' => $currentMonthStart, ':end_date' => $currentMonthEnd]
    );
    $kpi['collection_rate_month'] = $kpi['sales_month'] > 0
        ? min(100, max(0, ($salesPaidMonth / $kpi['sales_month']) * 100))
        : 0;

    $kpi['sales_due_total'] = $queryScalar("SELECT SUM(due_amount) AS total FROM invoice");
    $kpi['purchase_due_total'] = $queryScalar("SELECT SUM(purchase_due_bill) AS total FROM purchase_products");

    $kpi['low_stock_count'] = (int) $queryScalar("SELECT COUNT(*) AS total FROM products WHERE quantity <= alert_quanttity");
    $kpi['total_products'] = (int) $queryScalar("SELECT COUNT(*) AS total FROM products");
    $kpi['inventory_health'] = $kpi['total_products'] > 0
        ? (($kpi['total_products'] - $kpi['low_stock_count']) / $kpi['total_products']) * 100
        : 100;

    $stmt = $pdo->prepare(
        "SELECT
            SUM(CASE WHEN quantity > alert_quanttity THEN 1 ELSE 0 END) AS healthy,
            SUM(CASE WHEN quantity <= alert_quanttity AND quantity > 0 THEN 1 ELSE 0 END) AS low,
            SUM(CASE WHEN quantity = 0 THEN 1 ELSE 0 END) AS out_of_stock
         FROM products"
    );
    $stmt->execute();
    $stockRow = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    $chart['stock_status'] = [
        (int) ($stockRow['healthy'] ?? 0),
        (int) ($stockRow['low'] ?? 0),
        (int) ($stockRow['out_of_stock'] ?? 0),
    ];

    $stmt = $pdo->prepare(
        "SELECT invoice_number, customer_name, order_date, net_total, due_amount, payment_type
         FROM invoice
         ORDER BY order_date DESC, id DESC
         LIMIT 8"
    );
    $stmt->execute();
    $recentSales = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare(
        "SELECT product_name, quantity, alert_quanttity
         FROM products
         WHERE quantity <= alert_quanttity
         ORDER BY quantity ASC, id DESC
         LIMIT 8"
    );
    $stmt->execute();
    $lowStockItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare(
        "SELECT product_name, SUM(quantity) AS qty
         FROM invoice_details
         GROUP BY product_name
         ORDER BY qty DESC
         LIMIT 7"
    );
    $stmt->execute();
    $topProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($topProducts as $item) {
        $chart['top_product_labels'][] = (string) ($item['product_name'] ?? 'Unknown');
        $chart['top_product_values'][] = (int) ($item['qty'] ?? 0);
    }

    $stmt = $pdo->prepare(
        "SELECT COALESCE(payment_type, 'Unknown') AS label, SUM(net_total) AS total
         FROM invoice
         WHERE order_date >= :start_date AND order_date <= :end_date
         GROUP BY payment_type
         ORDER BY total DESC
         LIMIT 6"
    );
    $stmt->bindValue(':start_date', $currentMonthStart);
    $stmt->bindValue(':end_date', $currentMonthEnd);
    $stmt->execute();
    $paymentRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($paymentRows as $row) {
        $chart['payment_labels'][] = (string) ($row['label'] ?? 'Unknown');
        $chart['payment_values'][] = (float) ($row['total'] ?? 0);
    }

    $stmt = $pdo->prepare(
        "SELECT COALESCE(p.catagory_name, 'Uncategorized') AS category_name, SUM(d.quantity) AS total
         FROM invoice_details d
         LEFT JOIN products p ON p.id = d.pid
         GROUP BY p.catagory_name
         ORDER BY total DESC
         LIMIT 6"
    );
    $stmt->execute();
    $categoryRows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($categoryRows as $row) {
        $chart['category_labels'][] = (string) ($row['category_name'] ?? 'Uncategorized');
        $chart['category_values'][] = (int) ($row['total'] ?? 0);
    }

    try {
        $stmt = $pdo->prepare(
            "SELECT
                COUNT(*) AS total_items,
                COALESCE(SUM(COALESCE(s.quantity_available, 0)), 0) AS total_stock_units,
                COALESCE(SUM(COALESCE(s.quantity_available, 0) * COALESCE(os.unit_cost, 0)), 0) AS estimated_stock_value
             FROM office_supplies os
             LEFT JOIN stock s ON s.office_supply_id = os.id"
        );
        $stmt->execute();
        $summaryRow = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        $officeSuppliesSummary['total_items'] = (int) ($summaryRow['total_items'] ?? 0);
        $officeSuppliesSummary['total_stock_units'] = (int) ($summaryRow['total_stock_units'] ?? 0);
        $officeSuppliesSummary['estimated_stock_value'] = (float) ($summaryRow['estimated_stock_value'] ?? 0);
    } catch (Exception $ignored) {
        // Office supplies tables may not exist in every tenant DB.
    }
} catch (Exception $e) {
    $analyticsError = 'Unable to load analytics right now. ' . $e->getMessage();
}

$netTrend = [];
foreach ($monthKeys as $key) {
    $netTrend[] = ((float) ($chart['sales'][$key] ?? 0))
        - ((float) ($chart['purchases'][$key] ?? 0))
        - ((float) ($chart['expenses'][$key] ?? 0));
}

$isAnalyticsEmpty = array_sum(array_map('abs', array_values($chart['sales']))) === 0
    && array_sum(array_map('abs', array_values($chart['purchases']))) === 0
    && array_sum(array_map('abs', array_values($chart['expenses']))) === 0
    && $kpi['total_products'] === 0;
?>

<style>
    :root {
        --dash-bg: linear-gradient(155deg, #f8fbff 0%, #eef4ff 45%, #f7fbf7 100%);
        --dash-surface: #ffffff;
        --dash-text: #111827;
        --dash-muted: #64748b;
        --dash-border: #e5edf8;
        --dash-primary: #2563eb;
        --dash-primary-soft: #dbeafe;
        --dash-success: #16a34a;
        --dash-warning: #ea580c;
        --dash-danger: #dc2626;
        --dash-violet: #4338ca;
        --dash-shadow: 0 16px 30px rgba(15, 23, 42, 0.06);
        --dash-radius: 14px;
    }

    .dashboard-shell {
        width: 100%;
        max-width: 100%;
        box-sizing: border-box;
        padding: 24px;
        background: var(--dash-bg);
        border-radius: 16px;
        overflow-x: clip;
    }

    .dashboard-shell .row {
        margin-left: 0;
        margin-right: 0;
    }

    .dashboard-shell .row > [class*="col-"] {
        padding-left: 6px;
        padding-right: 6px;
    }

    .hero-band {
        background: linear-gradient(125deg, #0f172a 0%, #1e3a8a 52%, #0f766e 100%);
        border-radius: 18px;
        padding: 22px;
        color: #f8fafc;
        box-shadow: 0 18px 36px rgba(15, 23, 42, 0.18);
        margin-bottom: 18px;
    }

    .hero-band,
    .hero-band * {
        color: #ffffff !important;
    }

    .hero-title {
        margin: 0;
        font-size: 1.45rem;
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    .hero-subtitle {
        margin: 6px 0 0;
        color: #ffffff;
        font-size: 0.92rem;
    }

    .hero-stats {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 14px;
    }

    .hero-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.22);
        color: #f8fafc;
        border-radius: 999px;
        padding: 6px 12px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .dashboard-shell .card {
        border: 1px solid var(--dash-border);
        border-radius: var(--dash-radius);
        box-shadow: var(--dash-shadow);
        overflow: hidden;
    }

    .metric-card {
        background: var(--dash-surface);
        min-height: 114px;
    }

    .metric-card .card-body {
        padding: 16px;
    }

    .metric-label {
        color: var(--dash-muted);
        font-size: 0.8rem;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        font-weight: 600;
    }

    .metric-value {
        margin: 0;
        color: var(--dash-text);
        font-size: 1.2rem;
        font-weight: 700;
        line-height: 1.25;
    }

    .metric-note {
        margin-top: 8px;
        font-size: 0.78rem;
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .badge-analytics {
        border-radius: 999px;
        padding: 4px 10px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid transparent;
    }

    .badge-primary-soft {
        background: #e0eaff;
        color: #1e40af;
        border-color: #c6d9ff;
    }

    .badge-success-soft {
        background: #dcfce7;
        color: #166534;
        border-color: #bbf7d0;
    }

    .badge-warning-soft {
        background: #ffedd5;
        color: #9a3412;
        border-color: #fed7aa;
    }

    .chart-card .card-header,
    .data-card .card-header {
        background: #fff;
        border-bottom: 1px solid var(--dash-border);
        padding: 12px 16px;
    }

    .chart-title {
        margin: 0;
        color: #0f172a;
        font-size: 0.95rem;
        font-weight: 700;
    }

    .chart-subtitle {
        margin: 2px 0 0;
        color: #64748b;
        font-size: 0.78rem;
    }

    .chart-card .card-body {
        padding: 14px 16px 12px;
    }

    .chart-wrap {
        position: relative;
        min-height: 280px;
    }

    .chart-wrap.compact {
        min-height: 240px;
    }

    .analytics-table {
        width: 100%;
        border-collapse: collapse;
    }

    .analytics-table th,
    .analytics-table td {
        padding: 11px;
        border-bottom: 1px solid #edf2f8;
        font-size: 0.86rem;
        vertical-align: middle;
    }

    .analytics-table th {
        color: #475569;
        font-weight: 600;
        background: #f8fbff;
    }

    .analytics-table tbody tr:hover {
        background: #f7faff;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 3px 9px;
        font-size: 0.74rem;
        font-weight: 600;
    }

    .status-paid {
        background: #dcfce7;
        color: #166534;
    }

    .status-partial {
        background: #ffedd5;
        color: #9a3412;
    }

    .list-panel {
        padding: 10px 16px 14px;
    }

    .list-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 11px 0;
        border-bottom: 1px solid #edf2f8;
    }

    .list-row:last-child {
        border-bottom: 0;
    }

    .list-name {
        color: #0f172a;
        font-size: 0.87rem;
        font-weight: 600;
    }

    .list-meta {
        color: #64748b;
        font-size: 0.77rem;
        margin-top: 3px;
    }

    .list-chip {
        border-radius: 999px;
        background: #eef2ff;
        color: #3730a3;
        padding: 4px 9px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .supplies-summary {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 10px;
        margin-top: 10px;
    }

    .supplies-summary .box {
        border: 1px solid #e8eef8;
        border-radius: 10px;
        padding: 10px;
        background: #fafcff;
    }

    .supplies-summary .box .label {
        color: #64748b;
        font-size: 0.76rem;
        margin-bottom: 2px;
    }

    .supplies-summary .box .value {
        color: #0f172a;
        font-size: 1rem;
        font-weight: 700;
    }

    .supplies-table-wrap {
        overflow-x: auto;
        border: 1px solid #e8eef8;
        border-radius: 10px;
    }

    .supplies-table-wrap .analytics-table {
        min-width: 1020px;
    }

    .supplies-loading {
        display: grid;
        gap: 8px;
        padding: 10px 0;
    }

    .skeleton {
        height: 42px;
        border-radius: 8px;
        background: linear-gradient(95deg, #e8eef8 8%, #f8fbff 42%, #e8eef8 72%);
        background-size: 200% 100%;
        animation: pulseX 1.15s linear infinite;
    }

    @keyframes pulseX {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }

    .empty-state {
        padding: 14px;
        border: 1px dashed #cbd9ee;
        border-radius: 10px;
        background: #fbfdff;
        color: #64748b;
        font-size: 0.86rem;
        text-align: center;
    }

    @media (max-width: 1199.98px) {
        .dashboard-shell {
            padding: 16px;
        }

        .chart-wrap {
            min-height: 260px;
        }
    }

    @media (max-width: 991.98px) {
        .hero-title {
            font-size: 1.22rem;
        }

        .supplies-summary {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="content-wrapper" id="mainContent">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

  <section class="content">
    <div class="container-fluid">
        <div class="dashboard-shell" style="padding-top: 20px;">
            <div class="row">

                <div class="col-md-6 mb-4">
                    <div style="background: rgba(41, 128, 185, 0.1); border: 1px solid rgba(41, 128, 185, 0.3); padding: 25px; border-radius: 15px; height: 160px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: center;">
                        <div style="position: relative; z-index: 2;">
                            <h2 style="font-weight: 700; color: #2980b9; margin: 0; font-size: 1.5rem;">Office Supplies</h2>
                            <p style="color: #666; font-size: 0.85rem; margin-top: 5px;">DOTr Central Office | Monitoring Portal</p>
                            
                            <div style="margin-top: 15px;">
                                <a href="index.php?page=category" style="text-decoration: none;">
                                    <span style="background: #2980b9; color: white; padding: 7px 18px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; display: inline-block; transition: 0.3s;">
                                        View Categories
                                    </span>
                                </a>
                            </div>
                        </div>
                        <i class="fas fa-box" style="position: absolute; right: 15px; bottom: 15px; font-size: 4rem; color: rgba(41, 128, 185, 0.1);"></i>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
    <div style="background: rgba(192, 57, 43, 0.1); border: 1px solid rgba(192, 57, 43, 0.3); padding: 25px; border-radius: 15px; height: 160px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: center;">
        
        <div style="position: relative; z-index: 2;">
            <h2 style="font-weight: 700; color: #c0392b; margin: 0; font-size: 1.5rem;">Machinery & Equipment</h2>
            <p style="color: #666; font-size: 0.85rem; margin-top: 5px;">DOTr Central Office | Monitoring Portal</p>
            
            <div style="margin-top: 15px;">
                <a href="index.php?page=suppliar" style="text-decoration: none;">
                    <span style="background: #c0392b; color: white; padding: 7px 18px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; display: inline-block; transition: 0.3s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        View Categories
                    </span>
                </a>
            </div>
        </div>

        <i class="fas fa-cogs" style="position: absolute; right: 15px; bottom: 15px; font-size: 4rem; color: rgba(192, 57, 43, 0.1);"></i>
    </div>
</div>

               <div class="col-md-6 mb-4">
    <div style="background: rgba(192, 57, 43, 0.1); border: 1px solid rgba(192, 57, 43, 0.3); padding: 25px; border-radius: 15px; height: 160px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: center;">
        
        <div style="position: relative; z-index: 2;">
            <h2 style="font-weight: 700; color: #c0392b; margin: 0; font-size: 1.5rem;">Furnitures and Fixtures</h2>
            <p style="color: #666; font-size: 0.85rem; margin-top: 5px;">DOTr Central Office | Monitoring Portal</p>
            
            <div style="margin-top: 15px;">
                <a href="index.php?page=customers_report" style="text-decoration: none;">
                    <span style="background: #c0392b; color: white; padding: 7px 18px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; display: inline-block; transition: 0.3s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        View Categories
                    </span>
                </a>
            </div>
        </div>

        <i class="fas fa-cogs" style="position: absolute; right: 15px; bottom: 15px; font-size: 4rem; color: rgba(192, 57, 43, 0.1);"></i>
    </div>
</div>
 <div class="col-md-6 mb-4">
    <div style="background: rgba(192, 57, 43, 0.1); border: 1px solid rgba(192, 57, 43, 0.3); padding: 25px; border-radius: 15px; height: 160px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: center;">
        
        <div style="position: relative; z-index: 2;">
            <h2 style="font-weight: 700; color: #c0392b; margin: 0; font-size: 1.5rem;">Transportation Equipment</h2>
            <p style="color: #666; font-size: 0.85rem; margin-top: 5px;">DOTr Central Office | Monitoring Portal</p>
            
            <div style="margin-top: 15px;">
                <a href="index.php?page=suppliar_report" style="text-decoration: none;">
                    <span style="background: #c0392b; color: white; padding: 7px 18px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; display: inline-block; transition: 0.3s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        View Categories
                    </span>
                </a>
            </div>
        </div>

        <i class="fas fa-cogs" style="position: absolute; right: 15px; bottom: 15px; font-size: 4rem; color: rgba(192, 57, 43, 0.1);"></i>
    </div>
</div>

                <div class="col-md-6 mb-4">
                    <div style="background: rgba(41, 128, 185, 0.1); border: 1px solid rgba(41, 128, 185, 0.3); padding: 25px; border-radius: 15px; height: 160px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: center;">
                        <div style="position: relative; z-index: 2;">
                            <h2 style="font-weight: 700; color: #2980b9; margin: 0; font-size: 1.5rem;">Building and Structures</h2>
                            <p style="color: #666; font-size: 0.85rem; margin-top: 5px;">DOTr Central Office | Monitoring Portal</p>
                            
                            <div style="margin-top: 15px;">
                                <a href="index.php?page=sms" style="text-decoration: none;">
                                    <span style="background: #2980b9; color: white; padding: 7px 18px; border-radius: 6px; font-weight: 600; font-size: 0.85rem; display: inline-block; transition: 0.3s;">
                                        View Categories
                                    </span>
                                </a>
                            </div>
                        </div>
                        <i class="fas fa-box" style="position: absolute; right: 15px; bottom: 15px; font-size: 4rem; color: rgba(41, 128, 185, 0.1);"></i>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>

<style>
    /* Malinis na hover effect para sa buttons lang */
    a span:hover {
        opacity: 0.9;
        transform: scale(1.05);
    }
</style>