<?php
  error_reporting(0);
  include_once 'connectdb.php';
?>

<?php require_once 'inc/header.php'; ?>
<?php require_once 'inc/sidebar.php'; ?>

<?php
    // Kunin ang requested page, default ay dashboard
    $requestedPage = $_GET['page'] ?? 'dashboard';
    
    // Automatic na tinitingnan nito lahat ng PHP files sa loob ng "pages" folder
    $allowedPages = array_map(
        static function ($file) {
            return basename($file, '.php');
        },
        glob(__DIR__ . '/pages/*.php') ?: []
    );

    

    $pagePath = __DIR__ . '/pages/' . $requestedPage . '.php';

    // Check kung valid ang page at existing sa folder na "pages"
    if (in_array($requestedPage, $allowedPages, true) && is_file($pagePath)) {
        require_once $pagePath;
    } else {
        // Kung wala ang file sa pages folder, dito siya babagsak
        require_once __DIR__ . '/pages/dashboard.php'; 
    }
?>

<?php require_once 'inc/footer.php'; ?>