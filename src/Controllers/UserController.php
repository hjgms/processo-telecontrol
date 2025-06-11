<?php

namespace App\Controllers;

use App\Gateways\UserGateway;
use App\System\DatabaseConnector;
use App\Core\Request;
use App\Core\Response;
use App\Utils\Validator;

class UserController {
  private $db;

  private $userGateway;

  public function __construct()
  {
    $dbConnector = new DatabaseConnector;
    $this->db = $dbConnector->getConnection();

    $this->userGateway = new userGateway($this->db);
  }

  public static function auth(Request $request, Response $reponse)
  {
    $body = $request->body();

    try {
      $fields = Validator::validate([
        'email'    => $body['email'],
        'password' => $body['password'],
      ]);

      $user = User::authentication($fields);

      if (!$user) return ['error'=> 'Sorry, we could not authenticate you.'];

      return JWT::generate($user);
    } 
    catch (PDOException $e) {
      if ($e->errorInfo[0] === '08006') return ['error' => 'Sorry, we could not connect to the database.'];
      return ['error' => $e->errorInfo[0]];
    }
    catch (Exception $e) {
      return ['error' => $e->getMessage()];
    }
  }
}