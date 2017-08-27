<?php


namespace HelpMeAbstract\Controller\User;

use HelpMeAbstract\Output\CreatesFractalScope;
use HelpMeAbstract\Output\FractalAwareInterface;
use HelpMeAbstract\Repository\UserRepository;
use HelpMeAbstract\Transformer\UserTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\JsonApiSerializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetSingle implements FractalAwareInterface
{
    use CreatesFractalScope;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $vars): ResponseInterface
    {
        $user = $this->userRepository->find($vars['id']);

        if ($user === null) {
            return new JsonResponse([], 404);
        }

        $data = $this->outputItem($user, new UserTransformer(), 'users')->toArray();

        return new JsonResponse($data, 200);
    }
}