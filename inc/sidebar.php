
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
    <a href="index.php?page=dashboard" class="brand-link" aria-label="PRI Inventory System Dashboard">
        <img src="dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-semibold">PRI Inventory System</span>
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
                        <p>Stationery & Supplies</p>
                    </a>
                </li>

                <li class="nav-header sidebar-section-label" role="presentation">OPERATIONS</li>
                <li class="nav-item has-treeview <?php echo in_array($actual_link, ['add_expense', 'exspense_list', 'expense_catagory_list']) ? 'menu-open' : ''; ?>">
                    <a href="#" title="Expenses" class="nav-link <?php echo in_array($actual_link, ['add_expense', 'exspense_list', 'expense_catagory_list']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-money-bill-wave"></i>
                        <p>
                           Requisition and Issue Slip
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?page=add_expense" class="nav-link <?php echo $actual_link == 'add_expense' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Requisition</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=exspense_list" class="nav-link <?php echo $actual_link == 'exspense_list' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Updated Issue Slip</p>
                            </a>
                        </li>
                        <li class="nav-item">
                           
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo in_array($actual_link, ['buy_product', 'buy_list', 'buy_refund_list']) ? 'menu-open' : ''; ?>">
                   
                        
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            
                        </li>
                        <li class="nav-item">
                           
                        <li class="nav-item">
                            
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview <?php echo in_array($actual_link, ['add_stuff', 'staff_list']) ? 'menu-open' : ''; ?>">
                    <a href="#" title="Staff" class="nav-link <?php echo in_array($actual_link, ['add_stuff', 'staff_list']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                          Divisions
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?page=add_stuff" class="nav-link <?php echo $actual_link == 'add_stuff' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Division</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=staff_list" class="nav-link <?php echo $actual_link == 'staff_list' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Directory of Offices</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header sidebar-section-label" role="presentation">COMMUNICATION</li>
                <li class="nav-item has-treeview <?php echo in_array($actual_link, ['member', 'suppliar', 'customers_report', 'suppliar_report', 'sms']) ? 'menu-open' : ''; ?>">
                    <a href="#" title="Contacts" class="nav-link <?php echo in_array($actual_link, ['member', 'suppliar', 'customers_report', 'suppliar_report', 'sms']) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>
                            General Inventory
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="index.php?page=member" class="nav-link <?php echo $actual_link == 'member' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=suppliar" class="nav-link <?php echo $actual_link == 'suppliar' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Machinery & Equipment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=customers_report" class="nav-link <?php echo $actual_link == 'customers_report' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Furnitures and Fixtures</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=suppliar_report" class="nav-link <?php echo $actual_link == 'suppliar_report' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transportation Equipment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php?page=sms" class="nav-link <?php echo $actual_link == 'sms' ? 'active' : ''; ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Buildings and Structures</p>
                            </a>
                        </li>
                    </ul>
                </li>

               
                
                <li class="nav-header sidebar-section-label" role="presentation">SYSTEM</li>
                <li class="nav-item">
                     <a href="index.php?page=backup_database" title="Backup Database" class="nav-link <?php echo $actual_link == 'backup_database' ? 'active' : ''; ?>" <?php echo $actual_link == 'backup_database' ? 'aria-current="page"' : ''; ?>>
                        <i class="nav-icon fas fa-database"></i>
                        <p>Digital Archive</p>
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
