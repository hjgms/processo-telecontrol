<?php
require 'vendor/autoload.php';
ini_set('auto_detect_line_endings', '0');
use Dotenv\Dotenv;

use App\System\DatabaseConnector;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$dbConnection = (new DatabaseConnector())->getConnection();