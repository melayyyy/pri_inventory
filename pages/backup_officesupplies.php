<div class="col-lg-4">
            <section class="card chart-card" aria-labelledby="stockDistributionHeading">
                <div class="card-header">
                    <h2 id="stockDistributionHeading" class="chart-title"></h2>
                    <p class="chart-subtitle"></p>
                </div>
                <div class="card-body">
                    <div class="chart-wrap compact"><canvas id="stockChart"></canvas></div>
                </div>
            </section>
        </div>
    </div>

    <div class="row mt-3" style="row-gap: 12px;">
        <div class="col-lg-6">
            <section class="card chart-card" aria-labelledby="productRankHeading">
                <div class="card-header">
                    <h2 id="productRankHeading" class="chart-title"></h2>
                    <p class="chart-subtitle"></p>
                </div>
                <div class="card-body">
                    <div class="chart-wrap compact"><canvas id="topProductsChart"></canvas></div>
                </div>
            </section>
        </div>
        <div class="col-lg-3">
            <section class="card chart-card" aria-labelledby="paymentMixHeading">
                <div class="card-header">
                    <h2 id="paymentMixHeading" class="chart-title"></h2>
                    <p class="chart-subtitle"></p>
                </div>
                <div class="card-body">
                    <div class="chart-wrap compact"><canvas id="paymentChart"></canvas></div>
                </div>
            </section>
        </div>
        <div class="col-lg-3">
            <section class="card chart-card" aria-labelledby="categoryMixHeading">
                <div class="card-header">
                    <h2 id="categoryMixHeading" class="chart-title"></h2>
                    <p class="chart-subtitle"></p>
                </div>
                <div class="card-body">
                    <div class="chart-wrap compact"><canvas id="categoryChart"></canvas></div>
                </div>
            </section>
        </div>
    </div>

    <div class="row mt-3" style="row-gap: 12px;">
        <div class="col-lg-8">
            <section class="card data-card" aria-labelledby="recentSalesHeading">
                <div class="card-header d-flex justify-content-between align-items-center" style="gap: 8px;">
                    <h2 id="recentSalesHeading" class="chart-title">Recent Supply Issuances</h2>
                    <a href="index.php?page=sell_list" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0" style="overflow-x: auto;">
                    <table class="analytics-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Division</th>
                                <th>Item</th>
                                <th>Quantity</th>
            
                            <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($recentSales)): ?>
                                <tr>
                                    <td colspan="6"><div class="empty-state m-2">No supply issuances recorded for this period.</div></td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recentSales as $sale): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($sale['invoice_number'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo htmlspecialchars($sale['customer_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?php echo !empty($sale['order_date']) ? date('M d, Y', strtotime($sale['order_date'])) : 'N/A'; ?></td>
                                        <td>$<?php echo number_format((float) ($sale['net_total'] ?? 0), 2); ?></td>
                                        <td><?php echo htmlspecialchars($sale['payment_type'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td>
                                            <?php if ((float) ($sale['due_amount'] ?? 0) > 0): ?>
                                                <span class="status-badge status-partial">Partial</span>
                                            <?php else: ?>
                                                <span class="status-badge status-paid">Paid</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="col-lg-4">
            <section class="card data-card" aria-labelledby="lowStockHeading">
                <div class="card-header">
                    <h2 id="lowStockHeading" class="chart-title">Low Stock Alerts</h2>
                </div>
                <div class="list-panel">
                    <?php if (empty($lowStockItems)): ?>
                        <div class="empty-state">All products are above alert quantity.</div>
                    <?php else: ?>
                        <?php foreach ($lowStockItems as $item): ?>
                            <div class="list-row">
                                <div>
                                    <div class="list-name"><?php echo htmlspecialchars($item['product_name'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?></div>
                                    <div class="list-meta">Alert: <?php echo (int) ($item['alert_quanttity'] ?? 0); ?></div>
                                </div>
                                <span class="list-chip"><?php echo (int) ($item['quantity'] ?? 0); ?> left</span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <section class="card data-card" aria-labelledby="officeSuppliesHeading">
                <div class="card-header d-flex justify-content-between align-items-center" style="gap: 10px;">
                    <h2 id="officeSuppliesHeading" class="chart-title">Office Supplies </h2>
                    <span class="badge-analytics badge-primary-soft" id="officeSuppliesCount">
                        <?php echo number_format($officeSuppliesSummary['total_items']); ?> items
                    </span>
                </div>
                <div class="card-body">
                    <div class="supplies-summary">
                        <div class="box">
                            <div class="label">Total Items</div>
                            <div class="value" id="officeSuppliesTotalItems"><?php echo number_format($officeSuppliesSummary['total_items']); ?></div>
                        </div>
                        <div class="box">
                            <div class="label">Stock Units</div>
                            <div class="value" id="officeSuppliesStockUnits"><?php echo number_format($officeSuppliesSummary['total_stock_units']); ?></div>
                        </div>
                        <div class="box">
                            <div class="label">Estimated Stock Value</div>
                            <div class="value" id="officeSuppliesStockValue">$<?php echo number_format($officeSuppliesSummary['estimated_stock_value'], 2); ?></div>
                        </div>
                    </div>

                    <div id="officeSuppliesLoading" class="supplies-loading mt-3" aria-hidden="true" style="display:none;">
                        <div class="skeleton"></div>
                        <div class="skeleton"></div>
                        <div class="skeleton"></div>
                    </div>

                    <div id="officeSuppliesContainer" class="supplies-table-wrap mt-3" style="display: none;">
                        <table class="analytics-table" id="officeSuppliesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category</th>
                                    <th>Item Name</th>
                                    <th>Description</th>
                                    <th>Unit Cost</th>
                                    <th>Stocks</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                </tr>
                            </thead>
                            <tbody id="officeSuppliesTbody"></tbody>
                        </table>
                    </div>

                    <div id="officeSuppliesEmpty" class="empty-state mt-3" style="display:none;">
                        No office supplies found.
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
        </div>
    </section>
</div>

<script>
(function () {
    function money(value) {
        return '$' + Number(value || 0).toLocaleString(undefined, {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    const monthLabels = <?php echo json_encode($chart['months']); ?>;
    const salesSeries = <?php echo json_encode(array_values($chart['sales'])); ?>;
    const purchaseSeries = <?php echo json_encode(array_values($chart['purchases'])); ?>;
    const expenseSeries = <?php echo json_encode(array_values($chart['expenses'])); ?>;
    const netSeries = <?php echo json_encode($netTrend); ?>;

    const stockSeries = <?php echo json_encode($chart['stock_status']); ?>;
    const paymentLabels = <?php echo json_encode($chart['payment_labels']); ?>;
    const paymentValues = <?php echo json_encode($chart['payment_values']); ?>;
    const topProductLabels = <?php echo json_encode($chart['top_product_labels']); ?>;
    const topProductValues = <?php echo json_encode($chart['top_product_values']); ?>;
    const categoryLabels = <?php echo json_encode($chart['category_labels']); ?>;
    const categoryValues = <?php echo json_encode($chart['category_values']); ?>;

    const chartFont = "'Inter', 'Segoe UI', sans-serif";

    function getGridColor(alpha) {
        return 'rgba(100, 116, 139, ' + alpha + ')';
    }

    function createGradient(ctx, from, to) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 320);
        gradient.addColorStop(0, from);
        gradient.addColorStop(1, to);
        return gradient;
    }

    if (typeof Chart !== 'undefined') {
        Chart.defaults.color = '#334155';
        Chart.defaults.font.family = chartFont;

        const trendEl = document.getElementById('trendChart');
        if (trendEl) {
            const tctx = trendEl.getContext('2d');
            const salesFill = createGradient(tctx, 'rgba(37, 99, 235, 0.32)', 'rgba(37, 99, 235, 0.02)');

            new Chart(tctx, {
                data: {
                    labels: monthLabels,
                    datasets: [
                        {
                            type: 'line',
                            label: 'Sales',
                            data: salesSeries,
                            borderColor: '#2563eb',
                            backgroundColor: salesFill,
                            fill: true,
                            tension: 0.36,
                            borderWidth: 2.4,
                            pointRadius: 2.8,
                            pointHoverRadius: 4
                        },
                        {
                            type: 'line',
                            label: 'Purchases',
                            data: purchaseSeries,
                            borderColor: '#0f766e',
                            backgroundColor: 'rgba(15, 118, 110, 0.08)',
                            fill: false,
                            tension: 0.33,
                            borderDash: [6, 4],
                            borderWidth: 2.1,
                            pointRadius: 2.5
                        },
                        {
                            type: 'bar',
                            label: 'Expenses',
                            data: expenseSeries,
                            backgroundColor: 'rgba(234, 88, 12, 0.35)',
                            borderColor: 'rgba(234, 88, 12, 0.8)',
                            borderWidth: 1,
                            borderRadius: 8,
                            maxBarThickness: 24
                        },
                        {
                            type: 'line',
                            label: 'Net',
                            data: netSeries,
                            borderColor: '#4338ca',
                            backgroundColor: 'rgba(67, 56, 202, 0.08)',
                            fill: false,
                            tension: 0.3,
                            borderWidth: 2,
                            pointRadius: 0,
                            pointHoverRadius: 3
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 10,
                                boxHeight: 10,
                                padding: 14
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    return ctx.dataset.label + ': ' + money(ctx.parsed.y);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: getGridColor(0.2)
                            },
                            ticks: {
                                callback: function (value) {
                                    return '$' + Number(value).toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        const stockEl = document.getElementById('stockChart');
        if (stockEl) {
            new Chart(stockEl.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Healthy', 'Low Stock', 'Out of Stock'],
                    datasets: [{
                        data: stockSeries,
                        backgroundColor: ['#22c55e', '#f59e0b', '#ef4444'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '66%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 11,
                                padding: 11
                            }
                        }
                    }
                }
            });
        }

        const topProductsEl = document.getElementById('topProductsChart');
        if (topProductsEl) {
            new Chart(topProductsEl.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: topProductLabels,
                    datasets: [{
                        label: 'Units Sold',
                        data: topProductValues,
                        backgroundColor: '#4f46e5cc',
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    indexAxis: 'y',
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: getGridColor(0.14) }
                        },
                        y: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        const paymentEl = document.getElementById('paymentChart');
        if (paymentEl) {
            new Chart(paymentEl.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: paymentLabels.length ? paymentLabels : ['No Data'],
                    datasets: [{
                        data: paymentValues.length ? paymentValues : [1],
                        backgroundColor: paymentValues.length
                            ? ['#2563eb', '#0f766e', '#f59e0b', '#7c3aed', '#e11d48', '#0891b2']
                            : ['#cbd5e1'],
                        borderWidth: 0
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    cutout: '62%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 10, padding: 8 }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (ctx) {
                                    if (!paymentValues.length) return 'No Data';
                                    return ctx.label + ': ' + money(ctx.parsed);
                                }
                            }
                        }
                    }
                }
            });
        }

        const categoryEl = document.getElementById('categoryChart');
        if (categoryEl) {
            new Chart(categoryEl.getContext('2d'), {
                type: 'polarArea',
                data: {
                    labels: categoryLabels.length ? categoryLabels : ['No Data'],
                    datasets: [{
                        data: categoryValues.length ? categoryValues : [1],
                        backgroundColor: categoryValues.length
                            ? ['#2563eb99', '#0f766e99', '#f59e0b99', '#7c3aed99', '#e11d4899', '#0891b299']
                            : ['#cbd5e1'],
                        borderWidth: 1,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            beginAtZero: true,
                            grid: { color: getGridColor(0.2) },
                            angleLines: { color: getGridColor(0.2) }
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: { boxWidth: 10, padding: 8 }
                        }
                    }
                }
            });
        }
    }

    const suppliesLoading = document.getElementById('officeSuppliesLoading');
    const suppliesContainer = document.getElementById('officeSuppliesContainer');
    const suppliesEmpty = document.getElementById('officeSuppliesEmpty');
    const suppliesTbody = document.getElementById('officeSuppliesTbody');
    const suppliesCount = document.getElementById('officeSuppliesCount');
    const suppliesItemsEl = document.getElementById('officeSuppliesTotalItems');
    const suppliesUnitsEl = document.getElementById('officeSuppliesStockUnits');
    const suppliesValueEl = document.getElementById('officeSuppliesStockValue');

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function formatDate(value) {
        if (!value) return 'N/A';
        const d = new Date(value);
        if (Number.isNaN(d.getTime())) return String(value);
        return d.toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: '2-digit' });
    }

    function renderOfficeSupplies(rows) {
        suppliesTbody.innerHTML = '';
        rows.forEach(function (item) {
            const stock = Number(item.stocks || 0);
            const cost = Number(item.unit_cost || 0);
            const tr = document.createElement('tr');
            tr.innerHTML = ''
                + '<td>' + escapeHtml(item.id ?? '') + '</td>'
                + '<td>' + escapeHtml(item.category ?? 'Uncategorized') + '</td>'
                + '<td>' + escapeHtml(item.item_name ?? 'N/A') + '</td>'
                + '<td>' + escapeHtml(item.description ?? '-') + '</td>'
                + '<td>' + money(cost) + '</td>'
                + '<td>' + escapeHtml(stock) + '</td>'
                + '<td>' + escapeHtml(formatDate(item.created_at)) + '</td>'
                + '<td>' + escapeHtml(formatDate(item.updated_at)) + '</td>';
            suppliesTbody.appendChild(tr);
        });
    }

    async function loadOfficeSupplies() {
        if (!suppliesLoading || !suppliesContainer || !suppliesEmpty || !suppliesTbody || !suppliesCount) {
            return;
        }

        suppliesLoading.style.display = 'grid';
        suppliesContainer.style.display = 'none';
        suppliesEmpty.style.display = 'none';

        try {
            const response = await fetch('app/ajax/office_supplies_data.php', { credentials: 'same-origin' });
            const payload = await response.json();

            if (!response.ok || payload.status !== 'ok') {
                throw new Error(payload.message || 'Failed to load office supplies');
            }

            const rows = Array.isArray(payload.data) ? payload.data : [];
            let totalUnits = 0;
            let totalValue = 0;
            rows.forEach(function (item) {
                const stock = Number(item.stocks || 0);
                const cost = Number(item.unit_cost || 0);
                totalUnits += stock;
                totalValue += stock * cost;
            });

            suppliesCount.textContent = rows.length + ' items';
            if (suppliesItemsEl) suppliesItemsEl.textContent = Number(rows.length).toLocaleString();
            if (suppliesUnitsEl) suppliesUnitsEl.textContent = Number(totalUnits).toLocaleString();
            if (suppliesValueEl) suppliesValueEl.textContent = money(totalValue);

            if (!rows.length) {
                suppliesEmpty.style.display = 'block';
            } else {
                renderOfficeSupplies(rows);
                suppliesContainer.style.display = 'block';
            }
        } catch (error) {
            suppliesCount.textContent = 'Unavailable';
            suppliesEmpty.style.display = 'block';
            suppliesEmpty.textContent = 'Unable to load office supplies: ' + error.message;
        } finally {
            suppliesLoading.style.display = 'none';
        }
    }

    loadOfficeSupplies();
})();
</script>
