<?php

namespace Deezer\Application;

use Exception;
use Monolog\Logger;
use Slim\Views\Twig;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Http\Message\ResponseInterface;

use Deezer\Domain\Notification\Notification;
use Deezer\Domain\Notification\NotificationRepository;
use Deezer\Infrastructure\Notification\NotificationApi;

class NotificationApiController
{
    /** @var Logger */
    private $logger;

    /** @var Twig */
    private $renderer;

    /** @var NotificationApi */
    private $notificationApi;

    /** @var NotificationRepository */
    private $notificationRepository;

    /**
     * NotificationApiController constructor.
     * @param Twig $twig
     * @param Logger $logger
     * @param NotificationApi $notificationApi
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(Twig $twig, Logger $logger, NotificationApi $notificationApi, NotificationRepository $notificationRepository)
    {
        $this->logger = $logger;
        $this->renderer = $twig;
        $this->notificationApi = $notificationApi;
        $this->notificationRepository = $notificationRepository;
    }


    public function notificationAll(Request $request, Response $response)
    {
        return $response->withJson($this->notificationRepository->findAll());
    }

    public function notificationUser(Request $request, Response $response, $id)
    {
        return $response->withJson($this->notificationRepository->findByUser($id['id']));
    }

    public function notificationReadUser(Request $request, Response $response, $id)
    {
        return $response->withJson($this->notificationRepository->notificationsRead($id['id']));
    }

    public function notificationUnreadUser(Request $request, Response $response, $id)
    {
        return $response->withJson($this->notificationRepository->notificationsUnread($id['id']));
    }
    public function notificationRead(Request $request, Response $response, $id)
    {
        $this->notificationRepository->update($id['id']);
        return $response->withRedirect(('/notifications/'.$_SESSION['user']), 200);
    }

}
