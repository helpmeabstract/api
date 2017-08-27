<?php

namespace HelpMeAbstract\Transformer;

use HelpMeAbstract\Entity\Comment;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'author',
    ];

    /**
     * @var UserTransformer
     */
    private $authorTransformer;

    public function __construct(UserTransformer $authorTransformer = null)
    {
        $this->authorTransformer = $authorTransformer ?: new UserTransformer();
    }

    /**
     * @param Comment $comment
     *
     * @return array
     */
    public function transform(Comment $comment) : array
    {
        return [
            'id' => $comment->getId(),
            'created_date' => $comment->getCreateDate()->format(DATE_ATOM),
            'body' => $comment->getContents()->getBody(),
            'has_been_edited' => $comment->hasBeenEdited(),
            'revision_id' => $comment->getRevision()->getId(),
        ];
    }

    /**
     * @param Comment|null $comment
     *
     * @return \League\Fractal\Resource\Collection|void
     */
    public function includeAuthor(Comment $comment = null)
    {
        if ($comment === null) {
            return $this->null();
        }

        return $this->item($comment->getAuthor(), $this->authorTransformer);
    }
}
