<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/Db.php';

$app = AppFactory::create();

$app->get('/{name}', function (Request  $request, Response $response, array $args) {
    $response->getBody()->write("Hello ".$args['name']);
    return $response;
});

$app->get('/', function (Request  $request, Response $response) {
    $response->getBody()->write("Hello ");
    return $response;
});

//friends routes
require __DIR__ . '/../routes/friends.php';

$app->run();
