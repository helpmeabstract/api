<?php


namespace HelpMeAbstract\Controller\Comment;


use HelpMeAbstract\Output\CreatesFractalScope;
use HelpMeAbstract\Output\FractalAwareInterface;
use HelpMeAbstract\Repository\CommentRepository;
use HelpMeAbstract\Transformer\CommentTransformer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetCommentsForRevision implements FractalAwareInterface
{
    use CreatesFractalScope;

    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $vars): ResponseInterface
    {
        $comments = $this->commentRepository->findBy(['revision' => $vars['id']]);

        return new JsonResponse(
            $this->outputCollection($comments, new CommentTransformer(), 'comments')->toArray()
        );
    }
}