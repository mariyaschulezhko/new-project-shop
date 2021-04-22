<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once __DIR__ . '/vendor/autoload.php';


use components\Router;
use components\AdminBase;

$new = new Router;
$new->run();