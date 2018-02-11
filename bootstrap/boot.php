<?php
session_start();

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../libs/Helpers/HelperFunctions.php';

$kernel = new \Bootstrap\WebKernel();
$kernel->run();

