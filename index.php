<?php
define('PHPEX', strrchr(__FILE__, '.'));

define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);

define('APP_PATH', ROOT . 'libs' . DS);
define('CFG_PATH', ROOT . 'cfgs' . DS);


include CFG_PATH . 'CFGView' . PHPEX;
include CFG_PATH . 'CFGConfig' . PHPEX;
include CFG_PATH . 'CFGController' . PHPEX;

include APP_PATH . 'MVCView' . PHPEX;
include APP_PATH . 'MVCRequest' . PHPEX;
include APP_PATH . 'MVCTemplate' . PHPEX;
include APP_PATH . 'MVCBootstrap' . PHPEX;
include APP_PATH . 'MVCController' . PHPEX;

$dftCtrl = new CFGController();
$dftCtrl->addExtension('Controller');
$dftCtrl->addController('index');
$dftCtrl->addPath('controllers');
$dftCtrl->addMethod('index');

$dftView = new CFGView();
$dftView->addPath('views');
$dftView->addExtension('View');
$dftView->addLayout('default');

$cfg = new CFGConfig();
$cfg->addController($dftCtrl);
$cfg->addView($dftView);

$fR = new MVCRequest(isset($_GET['url'])? $_GET['url'] : NULL, $cfg);
$bS = new MVCBootstrap($fR, $cfg);
$bS->run();

?>
