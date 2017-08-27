<?php

namespace HelpMeAbstract\Controller\Proposal;

use Assert\Assert;
use Assert\Assertion;
use Doctrine\ORM\EntityManager;
use HelpMeAbstract\Entity\Revision;
use HelpMeAbstract\Event;
use HelpMeAbstract\Output\CreatesFractalScope;
use HelpMeAbstract\Output\FractalAwareInterface;
use HelpMeAbstract\Permission\RequiresCurrentUser;
use HelpMeAbstract\Repository\RevisionRepository;
use HelpMeAbstract\Response\BadRequestResponse;
use HelpMeAbstract\Response\NotFoundResponse;
use HelpMeAbstract\Transformer\RevisionTransformer;
use League\Event\EmitterAwareInterface;
use League\Event\EmitterAwareTrait;
use League\Route\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class UpdateProposal implements FractalAwareInterface, EmitterAwareInterface
{
    use RequiresCurrentUser;
    use CreatesFractalScope;
    use EmitterAwareTrait;

    private $revisionRepository;
    private $db;

    /**
     * @param EntityManager      $db
     * @param RevisionRepository $revisionRepository
     */
    public function __construct(EntityManager $db, RevisionRepository $revisionRepository)
    {
        $this->db = $db;
        $this->revisionRepository = $revisionRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $vars): ResponseInterface
    {
        Assertion::uuid($vars['id'], 'Invalid ID Provided');
        $proposal = $this->revisionRepository->findLatestForProposal($vars['id']);

        if ($proposal === null) {
            return new NotFoundResponse();
        }

        if ($proposal->getAuthor()->getId() !== $this->requireCurrentUser($request)->getId()) {
            throw new UnauthorizedException();
        }

        $contents = json_decode($request->getBody()->getContents(), true);
        if ($contents === null) {
            return new BadRequestResponse(['Bad Request']);
        }
        $attributes = $contents['data']['attributes'];

        Assertion::string($attributes['body'], 'Invalid Body');
        Assertion::string($attributes['title'], 'Invalid Title');
        Assert::that($attributes['sessionType'], 'Invalid Session Type')
            ->nullOr()
            ->inArray(Revision::VALID_SESSION_TYPES);

        Assertion::nullOrNumeric($attributes['maxCharacters'], 'Invalid max characters');

        $revision = new Revision(
            $attributes['body'],
            $attributes['title'],
            $proposal->getProposalId(),
            $proposal->getAuthor(),
            $attributes['sessionType'] ?? null,
            $attributes['maxCharacters'] ?? null
        );

        $this->db->persist($revision);
        $this->db->flush();

        $this->getEmitter()->emit(Event\Proposal::updated($revision, $proposal->getAuthor()));

        return new JsonResponse($this->outputItem($revision, new RevisionTransformer(), 'revisions')->toArray(), 200);
    }
}
