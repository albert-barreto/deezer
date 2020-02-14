<?php

namespace Deezer\Infrastructure;

use Monolog\Logger;
use Slim\Http\Request;
use Slim\Http\Response;

use Deezer\Domain\Notification\NotificationRepository;

class NotificationApi
{

    protected $logger;

    /** @var NotificationRepository */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository, $logger)
    {
        $this->logger = $logger;
        $this->notificationRepository = $notificationRepository;
    }

    public function notificationsByUser(int $id)
    {
        return json_encode($this->notificationRepository->findByUser($id));
    }

}
