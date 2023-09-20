<?php

require_once __DIR__ . '/stripe-php/init.php';

$customerName = $_POST['name'] ?? '';
$customerEmail = $_POST['email'] ?? '';
$token = $_POST['stripeToken'] ?? '';

// Exit
if (!$customerEmail || !$token) {
    $pkFile = __DIR__ . '/.pk';
    $pk = file_get_contents($pkFile);
    $pk = trim($pk);

    require_once __DIR__ . '/theme/template.php';
    die;
}

require_once __DIR__ . '/core/index.php';
