<?php

namespace App\Controllers;

use App\Gateways\ProdutoGateway;
use App\System\DatabaseConnector;
use App\Core\Request;
use App\Core\Response;
use App\Utils\Validator;

class ProdutoController {
  private $db;

  private $produtoGateway;

  public function __construct()
  {
    $dbConnector = new DatabaseConnector;
    $this->db = $dbConnector->getConnection();

    $this->produtoGateway = new ProdutoGateway($this->db);
  }

  public function getAll(Request $request, Response $reponse)
  {
    try {
      $produtos = $this->produtoGateway->findAll();

      $reponse::json([
        "sucess" => true,
        "error" => false,
        "massage" => "",
        "produtos" => $produtos
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
        'description' => $body['description'],
        'status' => $body['status'],
        'warranty_time' => $body['warranty_time'],
      ]);

      $this->produtoGateway->insert([
        'description' => $body['description'],
        'status' => $body['status'],
        'warranty_time' => $body['warranty_time'],
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
        'description' => $body['description'],
        'status' => $body['status'],
        'warranty_time' => $body['warranty_time'],
      ]);

      $this->produtoGateway->update(
        $body['id'],
        [
          'description' => $body['description'],
          'status' => $body['status'],
          'warranty_time' => $body['warranty_time'],
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
        'id' => $body['id'],
      ]);

      $this->produtoGateway->delete(
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