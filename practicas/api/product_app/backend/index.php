<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/vendor/autoload.php';

use TECWEB\MYAPI\CREATE\Create;
use TECWEB\MYAPI\READ\Read;
use TECWEB\MYAPI\UPDATE\Update;
use TECWEB\MYAPI\DELETE\Delete;


// Configuración inicial
$app = AppFactory::create();
$app->setBasePath('/tecweb/practicas/api/product_app/backend');

// Permite acceso a la API para que los metodos get, post, put y delete sean autorizados 
$app->add(function (Request $request, $handler): Response {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'Content-Type')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

/**
 * GET /product/{id}
 * Obtiene un producto por su ID
 */
$app->get('/product/{id}', function (Request $request, Response $response, array $args) {
    $_POST['id'] = $args['id'];
    $prodObj = new Read('marketzone');
    $prodObj->single($args['id']);
    $response->getBody()->write($prodObj->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

/**
 * GET /products
 * Obtiene todos los productos
 */
$app->get('/products', function (Request $request, Response $response) {
    $prodObj = new Read('marketzone');
    $prodObj->list();
    $response->getBody()->write($prodObj->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

/**
 * GET /products/{search}
 * Busca productos por el nombre
 */
$app->get('/products/{search}', function (Request $request, Response $response, array $args) {
    $_GET['search'] = $args['search'];
    $prodObj = new Read('marketzone');
    $prodObj->search($args['search']);
    $response->getBody()->write($prodObj->getData());
    return $response->withHeader('Content-Type', 'application/json');
});


/**
 * POST /product
 * Agrega un nuevo producto
 */
$app->post('/product', function (Request $request, Response $response) {
    $prodObj = new Create('marketzone');
    $prodObj->add(null);
    $response->getBody()->write($prodObj->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

/**
 * PUT /product
 * Actualiza un producto existente
 */
$app->put('/product', function (Request $request, Response $response) {
    $prodObj = new Update('marketzone');
    $prodObj->edit(null);
    return $response->withHeader('Content-Type', 'application/json');
});

/**
 * DELETE /product/{id}
 * Elimina un producto 
 */
$app->delete('/product/{id}', function (Request $request, Response $response, array $args) {
    $_GET['id'] = $args['id'];
    $prodObj = new Delete('marketzone');
    $prodObj->delete($args['id']);
    $response->getBody()->write($prodObj->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// Confirmar cambios antes de las solicitudes. 
$app->options('/{routes:.+}', function (Request $request, Response $response) {
    return $response;
});

// Ejecutar la aplicación
$app->run();

?>
