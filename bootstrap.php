<?php
require 'vendor/autoload.php';
ini_set('auto_detect_line_endings', '0');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

use App\System\DatabaseConnector;

$dbConnection = (new DatabaseConnector())->getConnection();