<?php

namespace Deezer\Infrastructure\Notification;

use PDO;
use Deezer\Domain\Notification\Notification;
use Deezer\Domain\Notification\NotificationRepository;

class NotificationDatabaseRepository implements NotificationRepository
{

    protected $logger;

    /** @var PDO $pdoConnection */
    private $pdoConnection;

    public function __construct(PDO $pdoConnection, $logger)
    {
        $this->logger        = $logger;
        $this->pdoConnection = $pdoConnection;
    }

    public function findAll(): array
    {
        $statement = $this->pdoConnection->query(
            'SELECT notification.id, message.id as message_id, message.type, message.content, DATEDIFF(message.period, CURDATE()) as period, user.name as author, message.description, notification.date, notification.status
	                    FROM deezer.notification INNER JOIN message ON notification.message_id = message.id INNER JOIN user ON user.id = notification.user_id ORDER BY notification.date DESC');

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByUser(int $id): array
    {
        $statement = $this->pdoConnection->prepare(
            'SELECT notification.id, message.id as message_id, message.type, DATEDIFF(message.period, CURDATE()) as period, user.name as author, message.description, notification.date, notification.status, message.content
	                    FROM deezer.notification INNER JOIN message ON notification.message_id = message.id INNER JOIN user ON user.id = notification.user_id WHERE notification.user_id = ? ORDER BY notification.date DESC');

        $statement->execute([$id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function notificationsRead(int $id): array
    {
        $statement = $this->pdoConnection->prepare(
            'SELECT notification.id, message.id as message_id, message.type, DATEDIFF(message.period, CURDATE()) as period, user.name as author, message.description, notification.date, notification.status, message.content
	                    FROM deezer.notification INNER JOIN message ON notification.message_id = message.id INNER JOIN user ON user.id = notification.user_id WHERE notification.user_id = ? AND notification.status = 1 ORDER BY notification.date DESC');

        $statement->execute([$id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function notificationsUnread(int $id): array
    {
        $statement = $this->pdoConnection->prepare(
            'SELECT notification.id, message.id as message_id, message.type,DATEDIFF(message.period, CURDATE()) as period, user.name as author, message.description, notification.date, notification.status, message.content
	                    FROM deezer.notification INNER JOIN message ON notification.message_id = message.id INNER JOIN user ON user.id = notification.user_id WHERE notification.user_id = ? AND notification.status = 0 ORDER BY notification.date DESC');

        $statement->execute([$id]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function notificationContent($messageId, $content)
    {
        $type = null;
        switch ($content) {
            case 'album':
                $type = ['type' => ucfirst($content)];
                $sql = 'SELECT album.title, album.year FROM album LEFT JOIN message_album ON album.id = message_album.album_id WHERE message_album.message_id = ?';
                break;
            case 'podcast':
                $type = ['type' => ucfirst($content)];
                $sql = 'SELECT podcast.title, podcast.year FROM podcast LEFT JOIN message_podcast ON podcast.id = message_podcast.podcast_id WHERE message_podcast.message_id = ?';
                break;
            case 'artist':
                $type = ['type' => ucfirst($content)];
                $sql = 'SELECT artist.name, artist.style FROM artist LEFT JOIN message_artist ON artist.id = message_artist.artist_id WHERE message_artist.message_id = ?';
                break;
            case 'playlist':
                $type = ['type' => ucfirst($content)];
                $sql = 'SELECT playlist.name FROM playlist LEFT JOIN message_playlist ON playlist.id = message_playlist.playlist_id WHERE message_playlist.message_id = ?';
                break;
            case 'track':
                $type = ['type' => ucfirst($content)];
                $sql = 'SELECT track.title, track.description FROM track LEFT JOIN message_track ON track.id = message_track.track_id WHERE message_track.message_id = ?';
                break;
        }

        $statement = $this->pdoConnection->prepare($sql);
        $statement->execute([$messageId]);
        return array_merge($type, $statement->fetchAll(PDO::FETCH_ASSOC)[0]);
    }

    public function insert(Notification $notification)
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

    public function update(int $id)
    {
        $parameters = ['id' => $id];
        $sql = 'UPDATE notification SET status = 0 WHERE id = :id';
        $this->pdoConnection->prepare($sql)->execute($parameters);
    }

}
