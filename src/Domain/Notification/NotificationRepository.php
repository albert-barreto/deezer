<?php


namespace Deezer\Domain\Notification;


interface NotificationRepository
{

    public function findAll();

    public function findByUser(int $id);

    public function notificationsRead(int $id);

    public function notificationsUnread(int $id);

    public function insert(Notification $notification);

    public function update(int $id);

}
