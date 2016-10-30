<?php

namespace HelpMeAbstract\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\TextResponse;

class Auth
{
    public function login(Request $request, Response $response, array $vars): Response
    {
        return new TextResponse('Help Me Abstract!');
    }

    public function logout(Request $request, Response $response, array $vars): Response
    {
        return new TextResponse('Help Me Abstract!');
    }
}
