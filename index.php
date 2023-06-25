<?php 
session_start();
require_once 'config.php';

// phpmailer
require_once 'includes/phpmailer/Exception.php';
require_once 'includes/phpmailer/PHPMailer.php';
require_once 'includes/phpmailer/SMTP.php';

require_once 'includes/functions.php';
require_once 'includes/connect.php';
require_once 'includes/session.php';
require_once 'includes/db.php';


$module = __DEFAULT_MODULE;
$action = __DEFAULT_ACTION;

if(!empty($_GET['module'])){
    $module = trim($_GET['module']);
}

if(!empty($_GET['action'])){
    $action = trim($_GET['action']);
}

$path = __MODULES .'/' .$module .'/' .$action .'.php';
if(file_exists($path)){
    require_once $path;
}else{
    require_once __NOT_FOUND;
}


