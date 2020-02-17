<?php

namespace Deezer\Infrastructure\Notification;

use Monolog\Logger;
use Deezer\Domain\Notification\NotificationRepository;

class NotificationApi
{

    protected $logger;

    /** @var NotificationRepository */
    private $notificationRepository;

    /**
     * NotificationApi constructor.
     * @param NotificationRepository $notificationRepository
     * @param $logger
     */
    public function __construct(NotificationRepository $notificationRepository, Logger $logger)
    {
        $this->logger = $logger;
        $this->notificationRepository = $notificationRepository;
    }

    public function notificationsByUser(int $id)
    {
        return json_encode($this->notificationRepository->findByUser($id));
    }

}
