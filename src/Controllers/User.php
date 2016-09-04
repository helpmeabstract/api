<?php

declare(strict_types=1);

namespace HelpMeAbstract\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Zend\Diactoros\Response\TextResponse;

class User implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function get(Request $request, Response $response): Response
    {
        return new TextResponse('Help Me Abstract!');
    }

    public function list(Request $request, Response $response): Response
    {
        $this->logger->alert("Look, ma! I'm loggin'!");

        return new TextResponse('Help Me Abstract!');
    }

    public function create(Request $request, Response $response): Response
    {
        return new TextResponse('Help Me Abstract!');
    }

    public function update(Request $request, Response $response): Response
    {
        return new TextResponse('Help Me Abstract!');
    }

    public function delete(Request $request, Response $response): Response
    {
        return new TextResponse('Help Me Abstract!');
    }
}
