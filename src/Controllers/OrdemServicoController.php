<?php

namespace App\Controllers;

use App\Gateways\OrdemServicoGateway;
use App\System\DatabaseConnector;
use App\Core\Request;
use App\Core\Response;
use App\Utils\Validator;

class ClienteController {
  private $db;

  private $ordemServicoGateway;

  public function __construct()
  {
    $dbConnector = new DatabaseConnector;
    $this->db = $dbConnector->getConnection();

    $this->ordemServicoGateway = new OrdemServicoGateway($this->db);
  }

  public function getAll(Request $request, Response $reponse)
  {
    try {
      $cliente = $this->ordemServicoGateway->findAll();

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

      ]);

      $this->ordemServicoGateway->insert();

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

      ]);

      $this->ordemServicoGateway->update();

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

      ]);

      $this->ordemServicoGateway->delete();

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