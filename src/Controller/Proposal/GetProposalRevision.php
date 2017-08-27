<?php


namespace HelpMeAbstract\Controller\Proposal;


use HelpMeAbstract\Output\CreatesFractalScope;
use HelpMeAbstract\Output\FractalAwareInterface;
use HelpMeAbstract\Repository\RevisionRepository;
use HelpMeAbstract\Response\NotFoundResponse;
use HelpMeAbstract\Transformer\RevisionTransformer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class GetProposalRevision implements FractalAwareInterface
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
        $includes = $request->getQueryParams()['include'] ?? [];

        $proposalId = $vars['id'];
        $revisionId = $vars['revision_id'] ?? null;

        $revision = $revisionId
            ? $this->repository->findOneBy(['id' => $revisionId])
            : $this->repository->findLatestForProposal($proposalId);

        if (!$revision){
            return new NotFoundResponse();
        }

        $this->manager->parseIncludes($includes);

        return new JsonResponse(
            $this->outputItem($revision, new RevisionTransformer(), 'revisions')->toArray()
        );
    }
}