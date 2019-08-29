<?php

Global $configClient;

$data = file_get_contents('php://input');
$signature = hash_hmac('sha1', $data, $configClient->getValue("deploySecret", ""));

if (!hash_equals("sha1={$signature}", $_SERVER['HTTP_X_HUB_SIGNATURE'])) {
    http_response_code(401);
    echo 'invalid signature';
    exit;
}

$data = json_decode($data, true);

$repoName = $data['repository']['name'];

$repos = [
    'CDN' => 'cdn.lucacastelnuovo.nl'
];

// host on test.luca

echo "/var/www/{$repos[$repoName]}";

// exec - git pull /var/www/$repos[$repoName]
