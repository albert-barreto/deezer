<?php

namespace Tests\Infrastructure\Notification;

use \PDO;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use Deezer\Infrastructure\Notification\NotificationDatabaseRepository;

class NotificationDatabaseRepositoryTest extends TestCase {

    /** @var Logger */
    private $logger;

    /** @var NotificationDatabaseRepository */
    private $notificationDatabaseRepository;

    public function setUp(): void {
        $this->PDO = $this->getConnection();
        $this->createTable();
        $this->populateTable();

        $this->notificationDatabaseRepository = new NotificationDatabaseRepository($this->PDO, $this->logger);
    }

    public function tearDown(): void {
        unset($this->notificationDatabaseRepository);
        unset($this->PDO);
    }

    public function testFindById() {
        $id = 1;

        $result = $this->notificationDatabaseRepository->findById($id);
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
            1,
            $result['id'],
            'The id key/value of the result for name should be equal to 1.'
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

        $notificationDatabaseRepository = new NotificationDatabaseRepository($PDO, $this->logger);

        $output = $notificationDatabaseRepository->findById($id);

        $this->assertEquals(
            1,
            $output,
            'The output for the mocked instance of the PDO and PDOStatment should produce the int 1.'
        );
    }

    protected function getConnection() {
        return new PDO('sqlite::memory:');
    }

    protected function createTable() {
        $query = "
		CREATE TABLE `notification` (
			`id`	     INTEGER,
			`user_id`	 INTEGER,
			`message_id` INTEGER,
			`status`     INTEGER,
			PRIMARY KEY(`id`)
		);
		";
        $this->PDO->query($query);
    }

    protected function populateTable() {
        $query = "
		INSERT INTO `notification` VALUES (1, 1, 1, 1);
		INSERT INTO `notification` VALUES (2, 2, 4, 0);
		";
        $this->PDO->query($query);
    }
}

