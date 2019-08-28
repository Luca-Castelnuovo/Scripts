<?php

require '../server.php';

$server = new Server($_GET['script_id']);

$server->start();
