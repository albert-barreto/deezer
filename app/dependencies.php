<?php

use Slim\Views\Twig;
use Slim\Views\TwigExtension;

use Deezer\Application\UserController;
use Deezer\Application\NotificationController;
use Deezer\Application\AuthenticationController;

use Deezer\Infrastructure\Middleware\Authentication;
use Deezer\Infrastructure\User\UserDatabaseRepository;
use Deezer\Infrastructure\Notification\NotificationApi;
use Deezer\Infrastructure\Notification\NotificationDatabaseRepository;

$container = $app->getContainer();

// TWIG
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['twig'];
    $view = new Twig($settings['template_path'],[
        'cache' => false,
        'debug' => true
    ]);
    $view->addExtension(new TwigExtension(
        $c->router,
        $c->request->getUri()
    ));
    return $view;
};

// PDO
$container['pdoConnection'] = function ($c) {

    $db = $c->settings['database'];
    $pdo = new PDO($db['conn'], $db['user'], $db['pass']);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
    return $pdo;
};

// MONOLOG
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// ---------------------------
// AUTHENTICATION
// ---------------------------
$container['authentication'] = function ($c) {
    return new Authentication($c->userRepository);
};

$container['authenticationController'] = function ($c) {
    return new AuthenticationController($c->renderer, $c->authentication);
};

// ---------------------------
// NOTIFICATION
// ---------------------------
$container['notificationApi'] = function ($c) {
    return new NotificationApi($c->notificationRepository, $c->logger);
};

$container['notificationRepository'] = function ($c) {
    return new NotificationDatabaseRepository($c->pdoConnection, $c->logger);
};

$container['notificationController'] = function ($c) {
    return new NotificationController($c->renderer, $c->logger, $c->notificationApi, $c->notificationRepository);
};

// ---------------------------
// USER
// ---------------------------
$container['userController'] = function ($c) {
    return new UserController($c->userRepository);
};

$container['userRepository'] = function ($c) {
    return new UserDatabaseRepository($c->pdoConnection, $c->logger);
};
