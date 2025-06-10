<?php
require __DIR__.'/../bootstrap.php';
header("Content-Type: application/json");

use App\Controllers\ProdutoController;
use App\Core\Router;
use App\Core\Request;

$router = new Router();

// Rotas de produtos
$router->register('GET', '/produtos', ['App\Controllers\ProdutoController', 'getAll']);
$router->register('POST', '/produtos', ['App\Controllers\ProdutoController', 'create']);
$router->register('PUT', '/produtos', ['App\Controllers\ProdutoController', 'update']);
$router->register('DELETE', '/produto', ['App\Controllers\ProdutoController', 'delete']);

$router->resolve(Request::method(), Request::path());