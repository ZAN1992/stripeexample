<?php

$whFile = __DIR__ . '/.wh';
$wh = file_get_contents($whFile);
$wh = trim($wh);

$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];

try {
    $stripe = new \Stripe\StripeClient($sk);
    require_once __DIR__ . '/core/App.php';
    App::eventListener($wh, $payload, $sig_header);
}
catch(Exception $ex) {
    echo 'Loading is not correct...';
}
