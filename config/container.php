<?php declare(strict_types=1);

use App\Factory\LoggerFactory;
use App\Middleware\SessionMiddleware;
use Psr\Container\ContainerInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

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

        // Configure error handler
        $app        = $container->get(App::class);
        $settings   = $container->get('settings')['error'];

        // Configure error log
        $loggerFactory  = $container->get(LoggerFactory::class);
        $logger         = $loggerFactory->addFileHandler('error.log')->createInstance('error');

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool)$settings['display_error_details'],
            (bool)$settings['log_errors'],
            (bool)$settings['log_error_details'],
            $logger
        );
    },

    // Detect base path.
    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    },

    // Logger
    LoggerFactory::class => function (ContainerInterface $container) {
        return new LoggerFactory($container->get('settings')['logger']);
    },

    // Twig templates
    Twig::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['twig'];

        $paths              = $settings['paths'];
        $options            = $settings['options'];
        $options['cache']   = $options['cache_enabled'] ? $options['cache_path'] : false;

        $twig = Twig::create($paths, $options);

        // Extensions go here

        return $twig;
    },

    TwigMiddleware::class => function (ContainerInterface $container) {
        return TwigMiddleware::createFromContainer(
            $container->get(App::class),
            Twig::class
        );
    },

    // Sessions
    Session::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['session'];

        // check for CLI environment
        if (PHP_SAPI === 'cli') {
            return new Session(new MockArraySessionStorage());
        } else {
            return new Session(new NativeSessionStorage($settings));
        }
    },

    SessionInterface::class => function (ContainerInterface $container) {
        return $container->get(Session::class);
    },
];
