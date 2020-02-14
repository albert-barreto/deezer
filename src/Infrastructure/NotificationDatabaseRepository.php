<?php


namespace Deezer\Infrastructure;


use PDO;
use Deezer\Domain\Notification\Notification;
use Deezer\Domain\Notification\NotificationRepository;

class NotificationDatabaseRepository implements NotificationRepository
{

    protected $logger;

    /** @var PDO $pdoConnection */
    private $pdoConnection;

    public function __construct(\PDO $pdoConnection, $logger)
    {
        $this->logger        = $logger;
        $this->pdoConnection = $pdoConnection;
    }

    public function findAll(): array
    {
        $statement = $this->pdoConnection->query(
            'SELECT notification.id_notification, message.type, message.content, message.period, user.name, message.description, notification.date, notification.status
                        FROM deezer.notification INNER JOIN message ON notification.id_message = message.id_message 
                        INNER JOIN user ON user.id_user = notification.id_user ORDER BY notification.date DESC');

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function findByUser(int $id): array
    {
        $statement = $this->pdoConnection->prepare(
            'SELECT notification.id_notification, message.type, message.content, message.period, user.name, message.description, notification.date, notification.status
                        FROM deezer.notification INNER JOIN message ON notification.id_message = message.id_message 
                        INNER JOIN user ON user.id_user = notification.id_user WHERE notification.id_user = ? ORDER BY notification.date DESC');

        $statement->execute([$id]);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function notificationsRead(int $id): array
    {
        $statement = $this->pdoConnection->prepare(
            'SELECT notification.id_notification, message.type, message.content, message.period, user.name, message.description, notification.date, notification.status
                        FROM deezer.notification INNER JOIN message ON notification.id_message = message.id_message 
                        INNER JOIN user ON user.id_user = notification.id_user WHERE notification.id_user = ? AND notification.status = 1 ORDER BY notification.date DESC');

        $statement->execute([$id]);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function notificationsUnread(int $id): array
    {
        $statement = $this->pdoConnection->prepare(
            'SELECT notification.id_notification, message.type, message.content, message.period, user.name, message.description, notification.date, notification.status
                        FROM deezer.notification INNER JOIN message ON notification.id_message = message.id_message 
                        INNER JOIN user ON user.id_user = notification.id_user WHERE notification.id_user = ? AND notification.status = 0 ORDER BY notification.date DESC');

        $statement->execute([$id]);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function insert(Notification $notification): void
    {
        $parameters = [
            'author' => $notification->getAuthor(),
            'content'  => $notification->getContent(),
            'description'  => $notification->getDescription(),
            'type'  => $notification->getType(),
            'period' => $notification->getPeriod()
        ];

        $sql = 'INSERT INTO message (author, content, description, type, period) VALUES (:author, :content, :description, :type, :period)';
        $this->pdoConnection->prepare($sql)->execute($parameters);
    }

    public function update(int $id): void
    {
        $parameters = ['id' => $id];
        $sql = 'UPDATE notification SET status = 0 WHERE id_notification = :id';
        $this->pdoConnection->prepare($sql)->execute($parameters);
    }

}
