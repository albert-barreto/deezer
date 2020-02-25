<?php


namespace Tests\Domain;

use PHPUnit\Framework\TestCase;
use Deezer\Domain\Notification\Notification;

class NotificationTest extends TestCase
{
    /** @var Notification */
    private $notification;

    public function setUp(): void
    {
        $this->notification = new Notification();
    }

    public function testGettersAndSettersAuthor(): void
    {
        $this->notification->setAuthor('Deezer');
        $this->assertEquals($this->notification->getAuthor(), 'Deezer');
    }

    public function testGettersAndSettersContent(): void
    {
        $this->notification->setContent('Album');
        $this->assertEquals($this->notification->getContent(), 'Album');
    }

    public function testGettersAndSettersDescription(): void
    {
        $this->notification->setDescription('Deezer');
        $this->assertEquals($this->notification->getDescription(), 'Deezer');
    }

    public function testGettersAndSettersType(): void
    {
        $this->notification->setType('recommandation');
        $this->assertEquals($this->notification->getType(), 'recommandation');
    }

    public function testGettersAndSettersPeriod(): void
    {
        $this->notification->setPeriod('2020-02-27');
        $this->assertEquals($this->notification->getPeriod(), '2020-02-27');
    }
}
