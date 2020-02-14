<?php

use Deezer\Infrastructure\Middleware\AuthenticationMiddleware;

// AUTHENTICATION
$app->group('/', function () use ($app) {
    $this->get('', 'authenticationController:viewAuth');
    $this->get('out', 'authenticationController:signOut');
});

$app->group('/auth', function () use ($app) {
    $this->get('', 'authenticationController:viewAuth');
    $this->post('', 'authenticationController:postAuth');
});

// API
$app->group('/api', function () use ($app) {

    $app->group('/notifications', function () use ($app) {

        $this->post('/new', 'notificationController:newNotification');

        $this->put('/read/{id:[0-9]+}', 'notificationController:notificationRead');

        $this->get('', 'notificationController:notificationAll');
        $this->get('/user/{id:[0-9]+}', 'notificationController:notificationUser');
        $this->get('/read/user/{id:[0-9]+}', 'notificationController:notificationReadUser');
        $this->get('/unread/user/{id:[0-9]+}', 'notificationController:notificationUnreadUser');

    });

    $app->group('/users', function () use ($app) {
        $this->get('', 'userController:getUsers');
        $this->get('/{id:[0-9]+}', 'userController:getUser');
        $this->post('', 'userController:newUser');
    });
});


// UI
$app->group('', function () use ($app) {

    $app->group('/notifications', function () use ($app) {

        $this->post('/new', 'notificationController:newNotification');
        //$this->put('/update', 'notificationController:updateNotification');
        $this->get('/add', 'notificationController:createNotification');
        $this->get('/read/{id:[0-9]+}', 'notificationController:notificationRead');
        $this->get('/{id:[0-9]+}', 'notificationController:viewNotification');
    });

})->add(new AuthenticationMiddleware($app->getContainer()));
