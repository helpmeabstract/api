<?php

namespace HelpMeAbstract\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Zend\Diactoros\Response\TextResponse;

class Notification implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function listForUser(Request $request, Response $response, array $vars): Response
    {
        return new TextResponse('Help Me Abstract!');
    }

    public function get(Request $request, Response $response, array $vars): Response
    {
        return new TextResponse('Help Me Abstract!');
    }

    public function update(Request $request, Response $response, array $vars): Response
    {
        return new TextResponse('Help Me Abstract!');
    }
}
