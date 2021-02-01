<?php

define('APP', ROOT . '/app/');
define('ENGINE', ROOT . '/engine/');
define('CONFIG', ROOT . '/config/');
define("CACHE",ROOT . '/storage/cache/');
define("LOGS",ROOT . '/storage/logs/');

define('IMAGE', ROOT . '/public/image/');
define('TEMPLATES', ROOT . '/templates/');

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('error_log', LOGS . '/errors.log');

require_once ENGINE . 'helpers.php';
require_once ROOT . '/vendor/autoload.php';

