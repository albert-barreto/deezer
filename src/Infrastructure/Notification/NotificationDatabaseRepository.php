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

    public function findAll()
    {
        $statement = $this->pdoConnection->query(
            'SELECT notification.id, message.id as message_id, message.type, message.period, user.name as author, message.description, notification.date, notification.status, message.content
	                    FROM deezer.notification INNER JOIN message ON notification.message_id = message.id 
                        INNER JOIN user ON user.id = notification.user_id ORDER BY notification.date DESC');

        $notifications = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->content($notifications);

    }

    public function findByUser(int $id)
    {
        $statement = $this->pdoConnection->prepare(
            'SELECT notification.id, message.id as message_id, message.type, message.period, user.name as author, message.description, notification.date, notification.status, message.content
	                    FROM deezer.notification INNER JOIN message ON notification.message_id = message.id
                        INNER JOIN user ON user.id = notification.user_id WHERE notification.user_id = ? ORDER BY notification.date DESC');

        $statement->execute([$id]);
        $notifications = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->content($notifications);
    }

    public function notificationsRead(int $id)
    {
        $statement = $this->pdoConnection->prepare(
            'SELECT notification.id, message.id as message_id, message.type, message.period, user.name as author, message.description, notification.date, notification.status, message.content
	                    FROM deezer.notification INNER JOIN message ON notification.message_id = message.id
                        INNER JOIN user ON user.id = notification.user_id WHERE notification.user_id = ? AND notification.status = 1 ORDER BY notification.date DESC');

        $statement->execute([$id]);
        $notifications = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->content($notifications);
    }

    public function notificationsUnread(int $id)
    {
        $statement = $this->pdoConnection->prepare(
            'SELECT notification.id, message.id as message_id, message.type, message.period, user.name as author, message.description, notification.date, notification.status, message.content
	                    FROM deezer.notification INNER JOIN message ON notification.message_id = message.id
                        INNER JOIN user ON user.id = notification.user_id WHERE notification.user_id = ? AND notification.status = 0 ORDER BY notification.date DESC');

        $statement->execute([$id]);
        $notifications = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $this->content($notifications);
    }

    public function content($notifications)
    {
        foreach ($notifications as $notification) {
            switch ($notification['content'])
            {
                case 'Album':
                    $statementContent = $this->pdoConnection->prepare('SELECT album.title, album.year FROM album LEFT JOIN message_album ON album.id = message_album.album_id WHERE message_album.message_id = ?');
                    $statementContent->execute([$notification['message_id']]);
                    $album[$notification['content']] = $statementContent->fetchAll(PDO::FETCH_ASSOC);
                    $result[] = array_merge($notification, $album);
                    break;
//                case 'User':
//                    $statementContent = $this->pdoConnection->prepare('SELECT user.name, user.email FROM deezer.message_user LEFT JOIN user ON message_user.message_id = user.id  WHERE message_user.message_id = ?');
//                    $statementContent->execute([$notification['message_id']]);
//                    $user[$notification['content']] = $statementContent->fetchAll(PDO::FETCH_ASSOC);
//                    $result[] = array_merge($notification, $user);
//                    break;
                case 'Podcast':
                    $statementContent = $this->pdoConnection->prepare('SELECT podcast.title, podcast.year FROM podcast LEFT JOIN message_podcast ON podcast.id = message_podcast.podcast_id WHERE message_podcast.message_id = ?');
                    $statementContent->execute([$notification['message_id']]);
                    $podcast[$notification['content']] = $statementContent->fetchAll(PDO::FETCH_ASSOC);
                    $result[] = array_merge($notification, $podcast);
                    break;
                case 'Artist':
                    $statementContent = $this->pdoConnection->prepare('SELECT artist.name, artist.style FROM artist LEFT JOIN message_artist ON artist.id = message_artist.artist_id WHERE message_artist.message_id = ?');
                    $statementContent->execute([$notification['message_id']]);
                    $artist[$notification['content']] = $statementContent->fetchAll(PDO::FETCH_ASSOC);
                    $result[] = array_merge($notification, $artist);
                    break;
                case 'Playlist':
                    $statementContent = $this->pdoConnection->prepare('SELECT playlist.name FROM playlist LEFT JOIN message_playlist ON playlist.id = message_playlist.playlist_id WHERE message_playlist.message_id = ?');
                    $statementContent->execute([$notification['message_id']]);
                    $playlist[$notification['content']] = $statementContent->fetchAll(PDO::FETCH_ASSOC);
                    $result[] = array_merge($notification, $playlist);
                    break;
                case 'Track':
                    $statementContent = $this->pdoConnection->prepare('SELECT track.title, track.description FROM track LEFT JOIN message_track ON track.id = message_track.track_id WHERE message_track.message_id = ?');
                    $statementContent->execute([$notification['message_id']]);
                    $track[$notification['content']] = $statementContent->fetchAll(PDO::FETCH_ASSOC);
                    $result[] = array_merge($notification, $track);
                    break;
            }

        }

        return $result;
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
