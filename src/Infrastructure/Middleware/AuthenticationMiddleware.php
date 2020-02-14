<?php

namespace Deezer\Infrastructure\Middleware;


class AuthenticationMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if (!$this->container->authentication->check()) {
           return $response->withRedirect('/out');
        }
        $response = $next($request, $response);
        return $response;
    }

}
