<?php
/**
 *
 */

require_once __DIR__.'/../vendor/autoload.php';

use Javanile\DocForge\Server;

$server = new Server(__DIR__.'/../docforge.json');

echo $server->run();
