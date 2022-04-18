<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

// Define app routes
$routes = require __DIR__ . DIRECTORY_SEPARATOR . 'routes.php';
$routes($app);

$app->run();
