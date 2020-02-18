<?php


namespace Deezer\Domain\Notification;


interface NotificationRepository
{

    public function findAll(): array;

    public function findByUser(int $id): array;

    public function notificationsRead(int $id): array;

    public function notificationsUnread(int $id): array;

    public function insert(Notification $notification);

    public function update(int $id);

}
