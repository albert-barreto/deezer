<?php

namespace Tests\Infrastructure\User;

use Monolog\Logger;
use Deezer\Domain\User\User;
use PHPUnit\Framework\TestCase;
use Deezer\Infrastructure\User\UserDatabaseRepository;
use Deezer\Infrastructure\User\UserDatabaseRepository\PDO;

class UserDatabaseRepositoryTest extends TestCase
{

    /** @var Logger */
    private $logger;

    /** @var User */
    private $user;

    /** @var UserDatabaseRepository */
    private $userDatabaseRepository;

    public function setUp(): void
    {
        $this->user = new User();
        $this->userDatabaseRepository = new UserDatabaseRepository(
            $this->createMock(\PDO::class),
            $this->createMock(\Logger::class)
        );
    }

    public function testFindAll()
    {

    }

}
