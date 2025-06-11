<?php

namespace App\Controllers;

use App\Gateways\ClienteGateway;
use App\System\DatabaseConnector;
use App\Core\Request;
use App\Core\Response;
use App\Utils\Validator;

class ClienteController {
  private $db;

  private $clienteGateway;

  public function __construct()
  {
    $dbConnector = new DatabaseConnector;
    $this->db = $dbConnector->getConnection();

    $this->clienteGateway = new ClienteGateway($this->db);
  }

  public function getAll(Request $request, Response $reponse)
  {
    try {
      $cliente = $this->clienteGateway->findAll();

      $reponse::json([
        "sucess" => true,
        "error" => false,
        "massage" => "",
        "size" => count($cliente),
        "clientes" => $cliente
      ]);
    } catch (Exception $e) {
      $reponse::json([
        "sucess" => false,
        "error" => true,
        "massage" => $e->getMessage(),
      ]);
      return;
    }
  }

  public function create(Request $request, Response $reponse)
  {
    $body = $request->body();

    try {
      Validator::validate([
        'name' => $body['name'],
        'cpf' => $body['cpf'],
        'address' => $body['address']
      ]);

      $this->clienteGateway->insert([
        "name" => $body['name'],
        "cpf" => $body['cpf'],
        "address" => $body['address']
      ]);

      $reponse::json([
        "sucess" => true,
        "error" => false,
        "massage" => ""
      ]);
    } catch (Exception $e) {
      $reponse::json([
        "sucess" => false,
        "error" => true,
        "massage" => $e->getMessage()
      ]);
    }
  }

  public function update(Request $request, Response $reponse)
  {
    $body = $request->body();

    try {
      Validator::validate([
        'id' => $body['id'],
        'name' => $body['name'],
        'cpf' => $body['cpf'],
        'address' => $body['address']
      ]);

      $this->clienteGateway->update(
        $body['id'], 
        [
          'name' => $body['name'],
          'cpf' => $body['cpf'],
          'address' => $body['address']
        ]
      );

      $reponse::json([
        "sucess" => true,
        "error" => false,
        "massage" => ""
      ]);
    } catch (Exception $e) {
      $reponse::json([
        "sucess" => false,
        "error" => true,
        "massage" => $e->getMessage()
      ]);
    }
  }

  public function delete(Request $request, Response $reponse)
  {
    $body = $request->body();

    try {
      Validator::validate([
        'id' => $body['id']
      ]);

      $this->clienteGateway->delete(
        $body['id']
      );

      $reponse::json([
        "sucess" => true,
        "error" => false,
        "massage" => ""
      ]);
    } catch (Exception $e) {
      $reponse::json([
        "sucess" => false,
        "error" => true,
        "massage" => $e->getMessage()
      ]);
    }
  }
}