<?php


namespace HelpMeAbstract\Controller\Proposal;


use HelpMeAbstract\Output\CreatesFractalScope;
use HelpMeAbstract\Output\FractalAwareInterface;
use HelpMeAbstract\Repository\RevisionRepository;
use HelpMeAbstract\Transformer\RevisionTransformer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetProposalRevisionList implements FractalAwareInterface
{
    use CreatesFractalScope;

    /**
     * @var RevisionRepository
     */
    private $repository;

    public function __construct(RevisionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $vars
    ): ResponseInterface
    {
        $proposalId = $vars['id'];

        $revisions =  $this->repository->findBy(['proposalId' => $proposalId], ['createdDate' => 'DESC']);

        $data = $this->outputCollection($revisions, new RevisionTransformer(), 'revisions')->toArray();

        return new JsonResponse($data, 200);
    }
}