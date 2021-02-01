<?php

if (!session_id()) {
	session_start();
}

define("ROOT",dirname(__DIR__));

require_once ROOT .'/config/bootstrap.php';

$router = new Engine\Core\Router();
$router->run();
