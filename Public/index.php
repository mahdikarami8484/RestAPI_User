<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Autoloader
require_once '../vendor/autoload.php';

// Load Config
require_once '../Config/config.php';

// Routes
require_once '../Routes/web.php';
require_once '../App/Router.php';

date_default_timezone_set("Asia/Tehran");

header('Content-Type: application/json; charset=utf-8');

