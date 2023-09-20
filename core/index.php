<?php

$skFile = __DIR__ . '/../.sk';
$sk = file_get_contents($skFile);
$sk = trim($sk);

try {
    $stripe = new \Stripe\StripeClient($sk);
    require_once __DIR__ . '/App.php';
    //$app = new App($_POST);
    App::createOrderWithSubscription(null, $stripe, $_POST);
}
catch(Exception $ex) {
    echo 'Loading is not correct...';
}

