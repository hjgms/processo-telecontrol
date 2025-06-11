<?php
require __DIR__.'/../bootstrap.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

use App\Controllers\ProdutoController;
use App\Controllers\HomeController;
use App\Core\Router;
use App\Core\Request;

$router = new Router();

// Rotas da aplicação
// $router->register('GET', '/', ['App\Controllers\HomeController', 'login']);
$router->register('GET', '/dashboard', ['App\Controllers\HomeController', 'dashboard']);

// Rotas de usuario
// $router->register('POST', '/login', ['App\Controllers\UsuarioController', 'login']);

// Rotas de produtos
$router->register('GET', '/produtos', ['App\Controllers\ProdutoController', 'getAll']);
$router->register('GET', '/produtos/filtro', ['App\Controllers\ProdutoController', 'filter']);
$router->register('POST', '/produtos', ['App\Controllers\ProdutoController', 'create']);
$router->register('PUT', '/produtos', ['App\Controllers\ProdutoController', 'update']);
$router->register('DELETE', '/produto', ['App\Controllers\ProdutoController', 'delete']);

// Rotas de clientes
$router->register('GET', '/clientes', ['App\Controllers\ClienteController', 'getAll']);
$router->register('POST', '/clientes', ['App\Controllers\ClienteController', 'create']);
$router->register('PUT', '/clientes', ['App\Controllers\ClienteController', 'update']);
$router->register('DELETE', '/cliente', ['App\Controllers\ClienteController', 'delete']);

// Rotas de ordemservicos
$router->register('GET', '/ordemservicos', ['App\Controllers\OrdemServicoController', 'getAll']);
$router->register('POST', '/ordemservicos', ['App\Controllers\OrdemServicoController', 'create']);
$router->register('PUT', '/ordemservicos', ['App\Controllers\OrdemServicoController', 'update']);
$router->register('DELETE', '/ordemservico', ['App\Controllers\OrdemServicoController', 'delete']);

$router->resolve(Request::method(), Request::path());