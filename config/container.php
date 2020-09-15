<?php declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

return [

    // Application settings.
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    // Application instance.
    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);
        return AppFactory::create();
    },

    // Handle errors.
    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app        = $container->get(App::class);
        $settings   = $container->get('settings')['error'];

        // TODO: Integrate logger

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details']
        );
    },

    // Detect base path.
    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    },

];
