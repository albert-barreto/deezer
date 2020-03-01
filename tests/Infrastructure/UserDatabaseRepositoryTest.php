<?php

namespace Tests\Infrastructure\Notification;


use \PDO;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Deezer\Infrastructure\User\UserDatabaseRepository;

class UserDatabaseRepositoryTest extends TestCase {

    /** @var Logger */
    private $logger;

    /** @var UserDatabaseRepository */
    private $userDatabaseRepository;

    public function setUp(): void {
        $this->PDO = $this->getConnection();
        $this->createTable();
        $this->populateTable();

        $this->userDatabaseRepository = new UserDatabaseRepository($this->PDO, $this->logger);
    }

    public function tearDown(): void {
        unset($this->userDatabaseRepository);
        unset($this->PDO);
    }

    public function testFindById() {
        $id = 1;

        $result = $this->userDatabaseRepository->findById($id);
        $this->assertInternalType(
            'array',
            $result,
            'The result should always be an array.'
        );
        $this->assertEquals(
            $id,
            $result['id'],
            'The id key/value of the result for id should be equal to the id.'
        );
        $this->assertEquals(
            'Deezer',
            $result['name'],
            'The id key/value of the result for name should be equal to `Deezer`.'
        );
    }

    public function testFindByIdMock() {
        $id = 1;

        $PDOStatement = $this->getMockBuilder('\PDOStatement')
            ->setMethods(['execute', 'fetch'])
            ->getMock();

        $PDOStatement->expects($this->once())
            ->method('execute')
            ->with([$id])
            ->will($this->returnSelf());
        $PDOStatement->expects($this->once())
            ->method('fetch')
            ->with($this->anything())
            ->will($this->returnValue(1));

        $PDO = $this->getMockBuilder('\PDO')
            ->setMethods(['prepare'])
            ->disableOriginalConstructor()
            ->getMock();

        $PDO->expects($this->once())
            ->method('prepare')
            ->with($this->stringContains('SELECT * FROM'))
            ->willReturn($PDOStatement);

        $notificationDatabaseRepository = new UserDatabaseRepository($PDO, $this->logger);

        $output = $notificationDatabaseRepository->findById($id);

        $this->assertEquals(
            'Deezer',
            $output,
            'The output for the mocked instance of the PDO and PDOStatment should produce the string `Deezer`.'
        );
    }

    protected function getConnection() {
        return new PDO('sqlite::memory:');
    }

    protected function createTable() {
        $query = "
		CREATE TABLE `user` (		        
            `id`	    INTEGER,
			`name`	    TEXT,
			`email`     TEXT,
			`password`  TEXT,
			`type`      TEXT,
			PRIMARY KEY(`id`)
		);
		";
        $this->PDO->query($query);
    }

    protected function populateTable() {
        $query = "
		    INSERT INTO `user` VALUES (1, 'Dezzer', 'deezer@deezer.com', '202cb962ac59075b964b07152d234b70', 'administrator');
		    INSERT INTO `user` VALUES (2, 'user 1', 'user1@deezer.com', '202cb962ac59075b964b07152d234b70', 'user');
		";
        $this->PDO->query($query);
    }
}

