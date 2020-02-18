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
        $this->get('', 'notificationApiController:notificationAll');
        $this->get('/user/{id:[0-9]+}', 'notificationApiController:notificationUser');
        $this->get('/read/user/{id:[0-9]+}', 'notificationApiController:notificationReadUser');
        $this->get('/unread/user/{id:[0-9]+}', 'notificationApiController:notificationUnreadUser');
    });
    $app->group('/notification', function () use ($app) {
        $this->get('/{id:[0-9]+}', 'notificationApiController:notification');
        $this->post('/new', 'notificationApiController:newNotification');
        $this->put('/read/{id:[0-9]+}', 'notificationApiController:notificationRead');
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
        $this->post('/new', 'notificationUiController:newNotification');
        $this->get('/add', 'notificationUiController:createNotification');
        $this->put('/update', 'notificationUiController:updateNotification');
        $this->get('/{id:[0-9]+}', 'notificationUiController:viewNotification');
        $this->get('/read/{id:[0-9]+}', 'notificationUiController:viewNotificationRead');
        $this->get('/unread/{id:[0-9]+}', 'notificationUiController:viewNotificationUnread');
    });
})->add(new AuthenticationMiddleware($app->getContainer()));
