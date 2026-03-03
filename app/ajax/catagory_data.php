<?php
require_once '../init.php';

$draw = isset($_POST['draw']) ? (int) $_POST['draw'] : 1;
$row = isset($_POST['start']) ? (int) $_POST['start'] : 0;
$rowperpage = isset($_POST['length']) ? (int) $_POST['length'] : 10;
$searchValue = isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '';

$allowedColumns = ['id', 'name', 'created_at'];
$columnIndex = isset($_POST['order'][0]['column']) ? (int) $_POST['order'][0]['column'] : 0;
$requestedColumn = isset($_POST['columns'][$columnIndex]['data']) ? $_POST['columns'][$columnIndex]['data'] : 'id';
$columnName = in_array($requestedColumn, $allowedColumns, true) ? $requestedColumn : 'id';
$columnSortOrder = isset($_POST['order'][0]['dir']) && strtolower($_POST['order'][0]['dir']) === 'desc' ? 'DESC' : 'ASC';

$searchQuery = '';
$searchArray = [];
if ($searchValue !== '') {
    $searchQuery = ' WHERE (CAST(id AS TEXT) LIKE :id OR name LIKE :name) ';
    $searchArray = [
        'id' => '%' . $searchValue . '%',
        'name' => '%' . $searchValue . '%',
    ];
}

$stmt = $pdo->prepare('SELECT COUNT(*) AS allcount FROM categories');
$stmt->execute();
$records = $stmt->fetch(PDO::FETCH_ASSOC);
$totalRecords = isset($records['allcount']) ? (int) $records['allcount'] : 0;

$stmt = $pdo->prepare('SELECT COUNT(*) AS allcount FROM categories ' . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch(PDO::FETCH_ASSOC);
$totalRecordwithFilter = isset($records['allcount']) ? (int) $records['allcount'] : 0;

$sql = 'SELECT id, name, created_at FROM categories ' . $searchQuery . ' ORDER BY ' . $columnName . ' ' . $columnSortOrder . ' LIMIT :limit OFFSET :offset';
$stmt = $pdo->prepare($sql);
foreach ($searchArray as $key => $search) {
    $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
}
$stmt->bindValue(':limit', $rowperpage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $row, PDO::PARAM_INT);
$stmt->execute();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

$data = [];
foreach ($records as $category) {
    $created = !empty($category['created_at']) ? date('Y-m-d', strtotime($category['created_at'])) : 'N/A';
    $data[] = [
        'id' => $category['id'],
        'name' => $category['name'],
        'description' => 'Created: ' . $created,
        'action' => '<span class="text-muted">-</span>',
    ];
}

$response = [
    'draw' => $draw,
    'iTotalRecords' => $totalRecords,
    'iTotalDisplayRecords' => $totalRecordwithFilter,
    'aaData' => $data,
];

echo json_encode($response);

