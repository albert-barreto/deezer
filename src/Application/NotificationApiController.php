<?php

namespace Deezer\Application;

use DateTime;
use Slim\Http\Request;
use Slim\Http\Response;

use Deezer\Domain\Notification\NotificationRepository;

class NotificationApiController
{

    /** @var NotificationRepository */
    private $notificationRepository;

    /**
     * NotificationApiController constructor.
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function notificationAll(Request $request, Response $response)
    {
        return $response->withJson($this->content($this->notificationRepository->findAll()), 200);
    }

    public function notification(Request $request, Response $response, $id)
    {
        return $response->withJson($this->content($this->notificationRepository->findById($id['id'])), 200);
    }

    public function notificationTotal(Request $request, Response $response, $id)
    {
        $data = [
            'read'   => count($this->notificationRepository->notificationsRead($id['id'])),
            'unread' => count($this->notificationRepository->notificationsUnread($id['id'])),
            'total'  => count($this->notificationRepository->notificationsRead($id['id'])) + count($this->notificationRepository->notificationsUnread($id['id']))
        ];
        return $response->withJson(['notifications' => $data], 200);
    }

    public function notificationUser(Request $request, Response $response, $id)
    {
        return $response->withJson($this->content($this->notificationRepository->findByUser($id['id']), 200));
    }

    public function notificationReadUser(Request $request, Response $response, $id)
    {
        return $response->withJson($this->content($this->notificationRepository->notificationsRead($id['id']), 200));
    }

    public function notificationUnreadUser(Request $request, Response $response, $id)
    {
        return $response->withJson($this->content($this->notificationRepository->notificationsUnread($id['id']), 200));
    }

    public function notificationRead(Request $request, Response $response, $id)
    {
        return $response->withJson($this->notificationRepository->update($id['id']), 200);
    }

    public function content($notifications)
    {
        foreach ($notifications as $notification) {
            switch ($notification['content'])
            {
                case 'Album':
                    $album['content'] = $this->notificationRepository->notificationContent($notification['message_id'], 'album');
                    unset($notification['message_id']);
                    array_filter($notification);
                    $result[] = array_merge($notification, $album);
                    break;
                case 'Podcast':
                    $podcast['content'] = $this->notificationRepository->notificationContent($notification['message_id'], 'podcast');
                    unset($notification['message_id']);
                    array_filter($notification);
                    $result[] = array_merge($notification, $podcast);
                    break;
                case 'Artist':
                    $artist['content'] = $this->notificationRepository->notificationContent($notification['message_id'], 'artist');
                    unset($notification['message_id']);
                    array_filter($notification);
                    $result[] = array_merge($notification, $artist);
                    break;
                case 'Playlist':
                    $playlist['content'] = $this->notificationRepository->notificationContent($notification['message_id'], 'playlist');
                    unset($notification['message_id']);
                    array_filter($notification);
                    $result[] = array_merge($notification, $playlist);
                    break;
                case 'Track':
                    $track['content'] = $this->notificationRepository->notificationContent($notification['message_id'], 'track');
                    unset($notification['message_id']);
                    array_filter($notification);
                    $result[] = array_merge($notification, $track);
                    break;
                default:
                    unset($notification['message_id']);
                    $result[] = array_filter($notification);
                    break;
            }
        }
        return $result;
    }

}
