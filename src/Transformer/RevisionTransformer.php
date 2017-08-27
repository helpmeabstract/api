<?php

namespace HelpMeAbstract\Transformer;

use HelpMeAbstract\Entity\Revision;
use League\Fractal\TransformerAbstract;

class RevisionTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'comments',
        'author'
    ];
    /**
     * @var CommentTransformer
     */
    private $commentTransformer;

    public function __construct(CommentTransformer $commentTransformer = null, UserTransformer $userTransformer = null)
    {
        $this->commentTransformer = $commentTransformer ?: new CommentTransformer();
        $this->userTransformer = $commentTransformer ?: new UserTransformer();
    }

    public function transform(Revision $revision) : array
    {
        return [
            'id' => $revision->getId(),
            'body' => $revision->getBody(),
            'title' => $revision->getTitle(),
            'sessionType' => $revision->getSessionType(),
            'maxCharacters' => $revision->getMaxCharacters(),
            'submissionId' => $revision->getProposalId(),
            'createdDate' => $revision->getCreateDate()
        ];
    }

    public function includeComments(Revision $revision = null)
    {
        if ($revision === null) {
            return $this->null();
        }

        return $this->collection($revision->getComments(), $this->commentTransformer, 'comments');
    }

    public function includeAuthor(Revision $revision = null)
    {
        if ($revision === null) {
            return $this->null();
        }

        return $this->item($revision->getAuthor(), $this->userTransformer, 'users');
    }
}
