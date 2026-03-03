<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/connection.php';

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    echo "This script must be run from CLI.\n";
    exit(1);
}

$categories = [
    'Sanitation & Hygiene',
    'Paper Products',
    'Filing & Storage',
    'Desk Essentials',
    'Writing & Correction',
    'Adhesives & Tapes',
    'Organization Tools',
    'Printer & Ink Supplies',
    'Meeting Room Supplies',
    'Pantry Supplies',
    'IT Accessories',
    'Cleaning Equipment',
    'Mailing & Shipping',
    'Electrical & Batteries',
    'Safety & First Aid',
    'Furniture Accessories'
];

$inserted = 0;
$existing = 0;

foreach ($categories as $name) {
    $check = $pdo->prepare('SELECT id FROM categories WHERE LOWER(name) = LOWER(?) LIMIT 1');
    $check->execute([$name]);
    $row = $check->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        $existing++;
        continue;
    }

    $insert = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
    $insert->execute([$name]);
    $inserted++;
}

$totalStmt = $pdo->prepare('SELECT COUNT(*) AS total FROM categories');
$totalStmt->execute();
$total = (int) ($totalStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0);

echo "Category seed completed.\n";
echo "Inserted: {$inserted}\n";
echo "Existing: {$existing}\n";
echo "Total categories: {$total}\n";
