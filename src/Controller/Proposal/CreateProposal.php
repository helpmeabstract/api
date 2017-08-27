<?php

namespace HelpMeAbstract\Controller\Proposal;

use Assert\Assert;
use Assert\Assertion;
use Doctrine\ORM\EntityManager;
use HelpMeAbstract\Entity\Revision;
use HelpMeAbstract\Output\CreatesFractalScope;
use HelpMeAbstract\Output\FractalAwareInterface;
use HelpMeAbstract\Permission\RequiresCurrentUser;
use HelpMeAbstract\Repository\RevisionRepository;
use HelpMeAbstract\Response\BadRequestResponse;
use HelpMeAbstract\Transformer\RevisionTransformer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response\JsonResponse;

class CreateProposal implements FractalAwareInterface
{
    use RequiresCurrentUser;
    use CreatesFractalScope;

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

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $user = $this->requireCurrentUser($request);

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
            Uuid::uuid4(),
            $user,
            $attributes['sessionType'] ?? null,
            $attributes['maxCharacters'] ?? null
        );

        $this->db->persist($revision);
        $this->db->flush();

        return new JsonResponse($this->outputItem($revision, new RevisionTransformer(), 'revisions')->toArray(), 200);
    }
}
