<?php


namespace HelpMeAbstract\Controller\Comment;


use Assert\Assert;
use Assert\Assertion;
use Doctrine\ORM\EntityManager;
use HelpMeAbstract\Entity\Comment;
use HelpMeAbstract\Entity\Revision;
use HelpMeAbstract\Output\CreatesFractalScope;
use HelpMeAbstract\Output\FractalAwareInterface;
use HelpMeAbstract\Permission\RequiresCurrentUser;
use HelpMeAbstract\Repository\CommentRepository;
use HelpMeAbstract\Repository\RevisionRepository;
use HelpMeAbstract\Response\BadRequestResponse;
use HelpMeAbstract\Response\NotFoundResponse;
use HelpMeAbstract\Transformer\CommentTransformer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class CreateComment implements FractalAwareInterface
{
    use CreatesFractalScope;
    use RequiresCurrentUser;

    /**
     * @var EntityManager
     */
    private $db;
    /**
     * @var CommentRepository
     */
    private $commentRepository;
    /**
     * @var RevisionRepository
     */
    private $revisionRepository;

    public function __construct(
        EntityManager $db,
        RevisionRepository $revisionRepository,
        CommentRepository $commentRepository
    ) {

        $this->db = $db;
        $this->commentRepository = $commentRepository;
        $this->revisionRepository = $revisionRepository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $vars
    ): ResponseInterface
    {
        Assertion::uuid($vars['id'], 'Invalid ID Provided');

        $user = $this->requireCurrentUser($request);

        /** @var Revision $revision */
        $revision = $this->revisionRepository->find($vars['id']);

        if ($revision === null) {
            return new NotFoundResponse();
        }

        $contents = json_decode($request->getBody()->getContents(), true);
        if ($contents === null) {
            return new BadRequestResponse(['Bad Request']);
        }
        $attributes = $contents['data']['attributes'];

        Assertion::string($attributes['contents'], 'Invalid Contents');

        Assertion::nullOrNumeric($attributes['startIndex'], 'Invalid start index');
        Assertion::nullOrNumeric($attributes['stopIndex'], 'Invalid stop index');

        $revision = new Comment(
            $user,
            $revision,
            new Comment\Snippet(
                $attributes['contents'],
                $attributes['startIndex'] ?? null,
                $attributes['stopIndex'] ?? null
            )
        );

        $this->db->persist($revision);
        $this->db->flush();

        return new JsonResponse($this->outputItem($revision, new CommentTransformer(), 'comments')->toArray(), 200);
    }
}