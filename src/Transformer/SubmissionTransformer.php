<?php

namespace HelpMeAbstract\Transformer;

use HelpMeAbstract\Entity\Proposal;
use League\Fractal\TransformerAbstract;

class SubmissionTransformer extends TransformerAbstract
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'author',
    ];

    /**
     * @var array
     */
    protected $defaultIncludes = [
        'revisions',
    ];
    /**
     * @var RevisionTransformer
     */
    private $revisionTransformer;

    public function __construct(
        UserTransformer $authorTransformer = null,
    RevisionTransformer $revisionTransformer = null
    ) {
        $this->authorTransformer = $authorTransformer ?: new UserTransformer();
        $this->revisionTransformer = $revisionTransformer ?: new RevisionTransformer();
    }

    /**
     * @param Submission $submission
     *
     * @return mixed
     */
    public function transform(Proposal $submission) : array
    {
        return [
            'id' => $submission->getIdentifier(),
        ];
    }

    /**
     * @param Submission|null $comment
     *
     * @return \League\Fractal\Resource\Collection|void
     */
    public function includeAuthor(Proposal $submission = null)
    {
        if ($submission === null) {
            return $this->null();
        }

        return $this->item($submission->getAuthor(), $this->authorTransformer);
    }

    /**
     * @param Submission|null $submission
     *
     * @return \League\Fractal\Resource\Collection|\League\Fractal\Resource\NullResource
     */
    public function includeComments(Proposal $submission = null)
    {
        if ($submission === null) {
            return $this->null();
        }

        return $this->collection($submission->getRevisions(), $this->revisionTransformer);
    }
}
