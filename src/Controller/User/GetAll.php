<?php


namespace HelpMeAbstract\Controller\User;


use HelpMeAbstract\Entity\User;
use HelpMeAbstract\Output\CreatesFractalScope;
use HelpMeAbstract\Output\FractalAwareInterface;
use HelpMeAbstract\Repository\UserRepository;
use HelpMeAbstract\Transformer\UserTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Serializer\JsonApiSerializer;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareTrait;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\JsonResponse;

class GetAll implements FractalAwareInterface
{
    use CreatesFractalScope;
    use LoggerAwareTrait;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(ServerRequestInterface $request, Response $response): Response
    {
        $users = $this->userRepository->findAll();

        $data = $this->outputCollection($users, new UserTransformer(), 'users')->toArray();

        return new JsonResponse($data, 200);
    }
}