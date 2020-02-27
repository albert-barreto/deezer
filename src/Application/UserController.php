<?php

namespace Deezer\Application;

use Exception;
use Slim\Http\Request;
use Slim\Http\Response;

use Deezer\Domain\User\{User, UserRepository};

class UserController
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers(Request $request, Response $response)
    {
        return $response->withJson($this->userMap($this->userRepository->findAll()));
    }

    public function getUser(Request $request, Response $response, $id)
    {
        return $response->withJson($this->userMap($this->userRepository->findById($id['id'])));
    }

    public function newUser(Request $request, Response $response)
    {
        $user = new User();
        $user->setName($request->getParsedBody()['name']);
        $user->setPassword($request->getParsedBody()['password']);
        $user->setType($request->getParsedBody()['type']);

        $this->userRepository->insert($user);
        return $response->withRedirect('/users', 200);
    }

    public function userMap($data) {
        return array_map(function (User $user) {
            return [
                'id'    => $user->getId(),
                'name'  => $user->getName(),
                'type'  => $user->getType()
            ];
        }, $data);
    }
}
