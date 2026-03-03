<?php
require '../init.php';

if (!isset($_POST)) {
    echo 'Invalid request';
    exit;
}

$cat_name = isset($_POST['cat_name']) ? trim($_POST['cat_name']) : '';

if ($cat_name === '') {
    echo 'Name field required';
    exit;
}

try {
    $checkStmt = $pdo->prepare('SELECT id FROM categories WHERE LOWER(name) = LOWER(?) LIMIT 1');
    $checkStmt->execute([$cat_name]);
    $exists = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($exists) {
        echo 'Category already exists';
        exit;
    }

    $insertStmt = $pdo->prepare('INSERT INTO categories (name) VALUES (?)');
    $result = $insertStmt->execute([$cat_name]);

    echo $result ? 'yes' : 'Failed to add category';
} catch (Exception $e) {
    echo 'Failed to add category';
}

