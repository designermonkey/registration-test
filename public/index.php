<?php

require __DIR__.'/../bootstrap.php';

use FastRoute\RouteCollector;
use Zend\Diactoros\Server;

use Example\Application\Main;
use Example\Application\Controller;
use Example\Application\Http\RouteDispatcher;

// $injector is defined in bootstrap.php
$main = new Main(
    $injector,
    $injector->make(RouteCollector::class),
    $injector->make(RouteDispatcher::class)
);

// Define Routes
$main->addRoute('GET', '/', Controller\DisplayRegistrationForm::class);
$main->addRoute('POST', '/', Controller\RegisterUser::class);
$main->addRoute('GET', '/validate/{field}', Controller\ValidateFields::class);


$server = Server::createServer(
    $main,
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_FILES
);

$server->listen();
