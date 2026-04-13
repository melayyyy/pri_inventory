<?php
  error_reporting(0); // Ito ang magtatanggal ng lahat ng "sulat-sulat" sa taas
  include_once 'connectdb.php';
?>

<?php require_once 'inc/header.php'; ?>
<?php require_once 'inc/sidebar.php'; ?>

  <!-- Content Wrapper. Contains page content -->

  <?php
        $requestedPage = $_GET['page'] ?? 'dashboard';
        $requestedPage = is_string($requestedPage) ? trim($requestedPage) : 'dashboard';

        $allowedPages = array_map(
          static function ($file) {
            return basename($file, '.php');
          },
          glob(__DIR__ . '/pages/*.php') ?: []
        );

        $isValidPageKey = preg_match('/^[a-zA-Z0-9_]+$/', $requestedPage) === 1;
        $pagePath = __DIR__ . '/pages/' . $requestedPage . '.php';

        if ($isValidPageKey && in_array($requestedPage, $allowedPages, true) && is_file($pagePath)) {
          require_once $pagePath;
        } else {
          require_once __DIR__ . '/pages/error_page.php';
        }
 ?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

 <?php require_once 'inc/footer.php'; ?>
