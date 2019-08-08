<?php

require_once __DIR__.'/../vendor/autoload.php';

use Javanile\Elegy\Server;

$server = new Server(__DIR__.'/../elegy.json');

echo $server->run();
