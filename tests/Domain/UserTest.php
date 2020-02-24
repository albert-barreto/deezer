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

    public function testGettersAndSettersType(): void
    {
        $this->user->setType(7);
        $this->assertEquals(
            7,
            $this->user->getType() === 7,
            'When you set the ID, the response must match the value set.'
        );
    }
}
