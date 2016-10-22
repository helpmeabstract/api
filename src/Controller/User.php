<?php

declare(strict_types=1);

namespace HelpMeAbstract\Controller;

use HelpMeAbstract\Repository\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\TextResponse;

class User implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function get(Request $request, Response $response, array $vars): Response
    {
        $user = $this->userRepository->find($vars['id']);

        if ($user === null) {
            return new JsonResponse([], 404);
        }

        return new TextResponse('Help Me Abstract!');
    }

    public function list(Request $request, Response $response): Response
    {
        $users = $this->userRepository->findAll();

        return new JsonResponse(count($users) . ' Users Found');
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
