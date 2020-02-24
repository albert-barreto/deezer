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
}
