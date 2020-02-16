<?php


namespace Deezer\Application;

use Slim\Views\Twig;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Http\Message\ResponseInterface;

use Deezer\Infrastructure\Middleware\Authentication;

class AuthenticationController
{
    /** @var Twig */
    private $renderer;

    /** @var Authentication */
    private $authentication;

    /**
     * AuthenticationController constructor.
     * @param Twig $twig
     * @param Authentication $authentication
     */
    public function __construct(Twig $twig, Authentication $authentication)
    {
        $this->renderer = $twig;
        $this->authentication = $authentication;
    }

    public function viewAuth(Request $request, Response $response)
    {
        $this->renderer->render($response, '/templates/login.html.twig');
    }

    public function signOut(Request $request, Response $response): ResponseInterface
    {
        $this->authentication->logout();
        return $response->withRedirect('/auth');
    }

    public function postAuth(Request $request, Response $response)
    {
        $auth = $this->authentication->attempt(
            $request->getParam('email'),
            md5($request->getParam('password'))
        );

        if(!$auth){
            return $response->withRedirect('/auth');
        }

        return $response->withRedirect('/notifications/'.$_SESSION['user']);
    }


}
