<?php

use Monolog\Logger;

return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' =>  dirname( __DIR__ , 1 ),
        ],

        'twig' => [
            'template_path' =>  dirname( __DIR__ , 1 ),
            'autoescape' => 'html'
        ],

        // Monolog settings
        'logger' => [
            'name' => 'deezer-notification-center',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : dirname( __DIR__ , 1 ) . '/logs/app.log',
            'level' => Logger::DEBUG,
        ],

        'database' => [
            'conn' => 'mysql:host=localhost;port=3306;dbname=deezer',
            'user' => 'root',
            'pass' => 'root'
        ],

    ],
];
