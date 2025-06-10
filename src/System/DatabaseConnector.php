<?php
namespace App\System;

use Dotenv\Dotenv;

class DatabaseConnector {

  private $dbConnection = null;

  public function __construct()
  {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();

    $host = $_ENV['DB_HOST'];
    $port = $_ENV['DB_PORT'];
    $db   = $_ENV['DB_DATABASE'];
    $user = $_ENV['DB_USERNAME'];
    $pass = $_ENV['DB_PASSWORD'];

    try {
      $this->dbConnection = new \PDO(
        "pgsql:host=$host;port=$port;dbname=$db",
        $user,
        $pass
      );
    } catch (\PDOException $e) {
      exit($e->getMessage());
    }
  }

  public function getConnection()
  {
    return $this->dbConnection;
  }
}