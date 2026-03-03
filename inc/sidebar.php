
<?php
$sessionUserName = isset($_SESSION['user_name']) && is_string($_SESSION['user_name']) ? trim($_SESSION['user_name']) : 'User';
$avatarInitial = strtoupper(substr($sessionUserName, 0, 1));
if ($avatarInitial === '') {
    $avatarInitial = 'U';
}
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 sidebar-redesign" aria-label="Primary Navigation">

    <!-- Brand Logo -->
    <a href="index.php?page=dashboard" class="brand-link" aria-label="Office Stock Dashboard">
        <img src="dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-semibold">Office Stock</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column">
        <a href="#mainContent" class="sr-only sr-only-focusable">Skip navigation</a>

        <!-- Sidebar Menu -->
        <nav class="mt-2 flex-grow-1" aria-label="Sidebar Menu">
            <ul class="nav nav-pills nav-sidebar flex-column sidebar-menu-list" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header sidebar-section-label" role="presentation">CORE</li>
                
                <li class="nav-item">
                    <a href="index.php?page=dashboard" title="Dashboard" class="nav-link <?php echo ($actual_link == 'dashboard' || $actual_link == '') ? 'active' : ''; ?>" <?php echo ($actual_link == 'dashboard' || $actual_link == '') ? 'aria-current="page"' : ''; ?>>
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="index.php?page=category" title="Categories" class="nav-link <?php echo $actual_link == 'category' ? 'active' : ''; ?>" <?php echo $actual_link == 'category' ? 'aria-current="page"' : ''; ?>>
                        <i class="nav-icon fas fa-th"></i>
                        <p>Categories</p>
                    </a>
                </li>

                <li class="nav-header sidebar-section-label" role="presentation">OPERATIONS</li>
                <li class="nav-item has-treeview <?php echo in_array($actual_link, ['quick_sell', 'sell_list', 'sell_return_list']) ? 'menu-open' : ''; ?>">
                    <a href="#" title="Sales" class="nav-link <?php echo in_array($actual_link, ['quick_sell', 'sell_list', 'sell_return_list']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Sales
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?page=quick_sell" class="nav-link <?php echo $actual_link == 'quick_sell' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Sale</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=sell_list" class="nav-link <?php echo $actual_link == 'sell_list' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=sell_return_list" class="nav-link <?php echo $actual_link == 'sell_return_list' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Returns</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo in_array($actual_link, ['add_expense', 'exspense_list', 'expense_catagory_list']) ? 'menu-open' : ''; ?>">
                    <a href="#" title="Expenses" class="nav-link <?php echo in_array($actual_link, ['add_expense', 'exspense_list', 'expense_catagory_list']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                            Expenses
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?page=add_expense" class="nav-link <?php echo $actual_link == 'add_expense' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Expense</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=exspense_list" class="nav-link <?php echo $actual_link == 'exspense_list' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expense List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=expense_catagory_list" class="nav-link <?php echo $actual_link == 'expense_catagory_list' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Expense Categories</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo in_array($actual_link, ['buy_product', 'buy_list', 'buy_refund_list']) ? 'menu-open' : ''; ?>">
                    <a href="#" title="Purchases" class="nav-link <?php echo in_array($actual_link, ['buy_product', 'buy_list', 'buy_refund_list']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            Purchases
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?page=buy_product" class="nav-link <?php echo $actual_link == 'buy_product' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Purchase</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=buy_list" class="nav-link <?php echo $actual_link == 'buy_list' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=buy_refund_list" class="nav-link <?php echo $actual_link == 'buy_refund_list' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Returns</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo in_array($actual_link, ['add_stuff', 'staff_list']) ? 'menu-open' : ''; ?>">
                    <a href="#" title="Staff" class="nav-link <?php echo in_array($actual_link, ['add_stuff', 'staff_list']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Staff
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?page=add_stuff" class="nav-link <?php echo $actual_link == 'add_stuff' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Staff</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=staff_list" class="nav-link <?php echo $actual_link == 'staff_list' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Staff List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header sidebar-section-label" role="presentation">COMMUNICATION</li>
                <li class="nav-item has-treeview <?php echo in_array($actual_link, ['member', 'suppliar', 'customers_report', 'suppliar_report', 'sms']) ? 'menu-open' : ''; ?>">
                    <a href="#" title="Contacts" class="nav-link <?php echo in_array($actual_link, ['member', 'suppliar', 'customers_report', 'suppliar_report', 'sms']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>
                            Contacts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?page=member" class="nav-link <?php echo $actual_link == 'member' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=suppliar" class="nav-link <?php echo $actual_link == 'suppliar' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Suppliers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=customers_report" class="nav-link <?php echo $actual_link == 'customers_report' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customer Balance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=suppliar_report" class="nav-link <?php echo $actual_link == 'suppliar_report' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Supplier Balance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=sms" class="nav-link <?php echo $actual_link == 'sms' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>SMS</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header sidebar-section-label" role="presentation">INSIGHTS</li>
                <li class="nav-item has-treeview <?php echo in_array($actual_link, ['profit_loss', 'sales_report', 'purchase_report', 'purchase_pay_report', 'sell_pay_report', 'total_report']) ? 'menu-open' : ''; ?>">
                    <a href="#" title="Reports" class="nav-link <?php echo in_array($actual_link, ['profit_loss', 'sales_report', 'purchase_report', 'purchase_pay_report', 'sell_pay_report', 'total_report']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?page=profit_loss" class="nav-link <?php echo $actual_link == 'profit_loss' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profit/Loss</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=sales_report" class="nav-link <?php echo $actual_link == 'sales_report' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=purchase_report" class="nav-link <?php echo $actual_link == 'purchase_report' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=sell_pay_report" class="nav-link <?php echo $actual_link == 'sell_pay_report' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Payments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=purchase_pay_report" class="nav-link <?php echo $actual_link == 'purchase_pay_report' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Payments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=total_report" class="nav-link <?php echo $actual_link == 'total_report' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Total Report</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="nav-header sidebar-section-label" role="presentation">SYSTEM</li>
                <li class="nav-item">
                     <a href="index.php?page=backup_database" title="Backup Database" class="nav-link <?php echo $actual_link == 'backup_database' ? 'active' : ''; ?>" <?php echo $actual_link == 'backup_database' ? 'aria-current="page"' : ''; ?>>
                        <i class="nav-icon fas fa-database"></i>
                        <p>Backup Database</p>
                    </a>
                </li>
            </ul>
        </nav>

        <div class="sidebar-user-footer">
            <a href="index.php?page=profile" class="sidebar-user-link" title="Open Profile">
                <div class="avatar-initial avatar-initial-md"><?php echo htmlspecialchars($avatarInitial, ENT_QUOTES, 'UTF-8'); ?></div>
                <div class="sidebar-user-meta">
                    <span class="sidebar-user-name"><?php echo htmlspecialchars($sessionUserName, ENT_QUOTES, 'UTF-8'); ?></span>
                    <span class="sidebar-user-role"><?php echo isset($_SESSION['user_role']) ? htmlspecialchars(ucfirst((string) $_SESSION['user_role']), ENT_QUOTES, 'UTF-8') : 'User'; ?></span>
                </div>
                <i class="fas fa-chevron-right sidebar-user-arrow" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <!-- /.sidebar -->
</aside>
    </div>
    <?php require_once 'inc/member_add_modal.php'; ?>
    <?php require_once 'inc/catagory_modal.php'; ?>
    <?php require_once 'inc/suppliar_modal.php'; ?>
    <?php require_once 'inc/expense_catagory_modal.php'; ?>
