<?php declare(strict_types=1);

use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;

return function (App $app) {

    // Rendering
    $app->addBodyParsingMiddleware();       // Parse json/xml/form data.
    $app->add(TwigMiddleware::class);       // Twig templates.

    // Routing
    $app->addRoutingMiddleware();           // Built-in Slim router.

    // Error handling
    $app->add(BasePathMiddleware::class);   // Detect base path.
    $app->add(ErrorMiddleware::class);      // Catch exceptions and errors.

};
