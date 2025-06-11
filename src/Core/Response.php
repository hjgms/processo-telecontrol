<?php
namespace App\Core;

class Response {
  public static function json(array $data = [], int $status = 200)
  {
    http_response_code($status);

    header("Content-Type: application/json");

    echo json_encode($data);
  }

  public static function view(string $view, array $data = [])
  {
    header("Content-Type: text/html; charset=utf-8");
    
    extract($data);
    require_once __DIR__.'/../../public/views/' . $view . '.html';
  }
}