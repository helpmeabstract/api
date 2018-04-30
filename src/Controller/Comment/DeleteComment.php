<?php

namespace HelpMeAbstract\Controller\Comment;

use Doctrine\ORM\EntityManager;
use HelpMeAbstract\Repository\CommentRepository;
use HelpMeAbstract\Response\NotFoundResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode;
use Zend\Diactoros\Response\JsonResponse;

class DeleteComment
{
    /**
     * @var EntityManager
     */
    private $db;
    /**
     * @var CommentRepository
     */
    private $commentRepository;

    public function __construct(EntityManager $db, CommentRepository $commentRepository)
    {
        $this->db = $db;
        $this->commentRepository = $commentRepository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        array $vars
    ): ResponseInterface {
        $comment = $this->commentRepository->find($vars['id']);

        if (!$comment) {
            return new NotFoundResponse();
        }

        $this->db->remove($comment);
        $this->db->flush();

        return new JsonResponse(null, StatusCode::NO_CONTENT);
    }
}
