<?php declare(strict_types=1);

use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return function (App $app) {

    $app->addBodyParsingMiddleware();       // Parse json/xml/form data.
    $app->addRoutingMiddleware();           // Built-in Slim router.
    $app->add(BasePathMiddleware::class);   // Detect base path.
    $app->add(ErrorMiddleware::class);      // Catch exceptions and errors.

};
