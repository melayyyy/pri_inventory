<?php
require_once 'app/init.php';
if ($Ouser->is_login() == false) {
  header("location:login.php");
  exit;
}
$actual_link = isset($_GET['page']) && is_string($_GET['page']) ? $_GET['page'] : 'dashboard';
$actual_link = preg_match('/^[a-zA-Z0-9_]+$/', $actual_link) ? $actual_link : 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Office Stock Manager</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  
  <!-- DataTables -->
  <link href='https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
  <!-- datepicker css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <!-- select2 css -->
  <link rel="stylesheet" type="text/css" href="plugins/select2/css/select2.min.css"/>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
  
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/style.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">

<div class="wrapper">
  <!-- Page Preloder -->
  <div id="page"></div>
  <style>#loading { display: none !important; }</style>
    
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light shadow-sm">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto align-items-center">
      
      <!-- Notifications (Placeholder) -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> No new messages
          </a>
        </div>
      </li>

      <!-- User Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
          <div class="user-panel d-flex mr-2">
             <div class="image p-0">
               <img src="dist/img/avatar5.png" class="img-circle elevation-1" alt="User Image" style="width: 30px; height: 30px;">
             </div>
          </div>
          <span class="text-dark font-weight-bold"><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : 'User'; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right shadow border-0">
          <a href="index.php?page=profile" class="dropdown-item">
            <i class="fas fa-user mr-2 text-muted"></i> Profile
          </a>
          <div class="dropdown-divider"></div>
          <a href="app/action/logout.php" class="dropdown-item text-danger">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
          </a>
        </div>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->
