<?php


namespace Tests\Domain;

use Deezer\Domain\User\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    /** @var User */
    private $user;

    public function setUp(): void
    {
        $this->user = new User();
    }

    public function testGettersAndSettersId(): void
    {
        $this->user->setId(7);
        $this->assertEquals(
            7,
            $this->user->getId() === 7,
            'When you set the ID, the response must match the value set.'
        );
    }

    public function testGettersAndSettersName(): void
    {
        $this->user->setName('deezer');
        $this->assertEquals($this->user->getName(), 'deezer');
    }

    public function testGettersAndSettersType(): void
    {
        $this->user->setType('user');
        $this->assertEquals($this->user->getType(), 'user');
    }
}
