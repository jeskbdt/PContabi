<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$arquivoFisico = __DIR__ . $uri;

if ($uri !== '/' && is_file($arquivoFisico)) {
    return false;
}

require_once __DIR__ . '/../app/core/Autoload.php';
require_once __DIR__ . '/../app/config/Config.php';

use app\core\Router;

$router = new Router();

$router->get('/', 'AutenticacaoController@login');
$router->get('/login', 'AutenticacaoController@login');
$router->post('/logar', 'AutenticacaoController@logar');
$router->get('/logout', 'AutenticacaoController@logout');
$router->get('/dashboard', 'DashboardController@index');
$router->get('/register', 'UsuarioController@register');
$router->post('/register', 'UsuarioController@registerSave');
$router->get('/marcas', 'MarcaController@index');
$router->get('/marcas/cadastrar', 'MarcaController@cadastrar');
$router->post('/marcas/salvar', 'MarcaController@salvar');
$router->get('/marcas/editar', 'MarcaController@editar');
$router->post('/marcas/atualizar', 'MarcaController@atualizar');
$router->post('/marcas/excluir', 'MarcaController@excluir');
$router->get('/patentes', 'PatenteController@index');
$router->get('/patentes/cadastrar', 'PatenteController@cadastrar');
$router->post('/patentes/salvar', 'PatenteController@salvar');
$router->get('/patentes/editar', 'PatenteController@editar');
$router->post('/patentes/atualizar', 'PatenteController@atualizar');
$router->post('/patentes/excluir', 'PatenteController@excluir');
$router->get('/clientes', 'ClienteController@index');
$router->get('/clientes/cadastrar', 'ClienteController@cadastrar');
$router->post('/clientes/salvar', 'ClienteController@salvar');
$router->get('/clientes/editar', 'ClienteController@editar');
$router->post('/clientes/atualizar', 'ClienteController@atualizar');
$router->post('/clientes/excluir', 'ClienteController@excluir');
$router->get('/usuarios', 'UsuarioController@index');
$router->get('/usuarios/cadastrar', 'UsuarioController@cadastrar');
$router->post('/usuarios/salvar', 'UsuarioController@salvar');
$router->get('/usuarios/editar', 'UsuarioController@editar');
$router->post('/usuarios/atualizar', 'UsuarioController@atualizar');
$router->get('/usuarios/excluir', 'UsuarioController@excluir');
$router->get('/minha-conta/excluir-dados', 'UsuarioController@excluirDados');
$router->post('/minha-conta/excluir-dados', 'UsuarioController@confirmarExclusaoDados');

$router->run();
