<?php

Global $configClient;

$data = file_get_contents('php://input');
$signature = hash_hmac('sha1', $data, $configClient->getValue("deploySecret", ""));
// $data = json_decode($data, true);

if (!hash_equals("sha1={$signature}", $_SERVER['HTTP_X_HUB_SIGNATURE'])) {
    echo 'invalid signature';
    exit;
}

file_put_contents('hooks.log', $data);
