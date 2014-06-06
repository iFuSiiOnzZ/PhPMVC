<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT . 'application' . DS);
define('PHPEX', strrchr(__FILE__, '.'));

include APP_PATH . 'MVCRequest' . PHPEX;
include APP_PATH . 'MVCBootstrap' . PHPEX;
include APP_PATH . 'MVCController' . PHPEX;

$fR = new MVCRequest(isset($_GET['url'])? $_GET['url'] : NULL, 'index', 'index');
$bS = new MVCBootstrap($fR, 'controllers', 'Controller');
$bS->run();

?>
