<?php

namespace Deezer\Infrastructure\Middleware;

use Deezer\Domain\User\UserRepository;

class Authentication
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function check()
    {
        return isset($_SESSION['user']);
    }

    public function attempt($email, $password)
    {
        $user = $this->userRepository->findByEmail($email);
        if ($user->getPassword() === $password) {
            $_SESSION['user'] = $user->getId();
            $_SESSION['name'] = $user->getName();
            return true;
        }

        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }

}
