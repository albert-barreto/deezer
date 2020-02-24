<?php

namespace Tests\Infrastructure\User;

use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Deezer\Infrastructure\Notification\NotificationDatabaseRepository;
use Deezer\Infrastructure\Notification\NotificationDatabaseRepository\PDO;

class NotificationDatabaseRepositoryTest extends TestCase
{

    /** @var Logger */
    private $logger;

    /** @var NotificationDatabaseRepository */
    private $notificationDatabaseRepository;

    public function setUp(): void
    {
        $this->notificationDatabaseRepository = new NotificationDatabaseRepository (
            $this->createMock(\PDO::class),
            $this->createMock(\Logger::class)
        );
    }
    
}
