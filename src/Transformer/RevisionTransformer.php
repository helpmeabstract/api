<?php

namespace HelpMeAbstract\Transformer;

use HelpMeAbstract\Entity\Revision;
use League\Fractal\TransformerAbstract;

class RevisionTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'comments',
    ];
    /**
     * @var CommentTransformer
     */
    private $commentTransformer;

    public function __construct(CommentTransformer $commentTransformer = null)
    {
        $this->commentTransformer = $commentTransformer ?: new CommentTransformer();
    }

    public function transform(Revision $revision) : array
    {
        return [
            'id' => $revision->getId(),
            'submission_id' => $revision->getSubmissionIdentifier(),
        ];
    }

    public function includeComments(Revision $revision = null)
    {
        if ($revision === null) {
            return $this->null();
        }

        return $this->collection($revision->getComments(), $this->commentTransformer);
    }
}
