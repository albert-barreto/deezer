<?php

namespace Deezer\Application;

use Couchbase\LookupInBuilder;
use DateTime;
use Monolog\Logger;
use Slim\Views\Twig;
use Slim\Http\Request;
use Slim\Http\Response;
use GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;

use Deezer\Infrastructure\NotificationApi;
use Deezer\Domain\Notification\Notification;
use Deezer\Domain\Notification\NotificationRepository;

class NotificationController
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
     * NotificationController constructor.
     * @param Twig $twig
     * @param NotificationApi $notificationApi
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(Twig $twig, $logger, NotificationApi $notificationApi, NotificationRepository $notificationRepository)
    {
        $this->renderer = $twig;
        $this->notificationApi = $notificationApi;
        $this->notificationRepository = $notificationRepository;
    }

    public function viewNotification(Request $request, Response $response, $id)
    {
        $variables = [
            'user'   => $_SESSION['name'],
            'all'    => $this->notificationRepository->findByUser($id['id']),
            'read'   => $this->notificationRepository->notificationsRead($id['id']),
            'unread' => $this->notificationRepository->notificationsRead($id['id']),
            'notifications' => json_decode($this->notificationApi->notificationsByUser($id['id']))];
        return $this->renderer->render($response, '/templates/index.html.twig', $variables);
    }

    public function createNotification(Request $request, Response $response): ResponseInterface
    {
        return $this->renderer->render($response, '/templates/form.html.twig');
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

    public function notificationAll(Request $request, Response $response)
    {
        return $response->withJson($this->notificationRepository->findAll());
    }

    public function newNotification(Request $request, Response $response)
    {
        $notification = new Notification();
        $parsedBody = $request->getParsedBody();
        $notification->setAuthor($parsedBody['author']);
        $notification->setContent($parsedBody['content']);
        $notification->setDescription($parsedBody['description']);
        $notification->setType($parsedBody['type']);
        $notification->setPeriod($parsedBody['period']);

        try {
            $this->notificationRepository->insert($notification);
        } catch (\Exception $e) {
            //$this->logger->error('Error - Unable to create a new notification: '. $e->getMessage());
        }
        return $response->withRedirect('/notifications/'.$_SESSION['user'], 200);
    }

}
