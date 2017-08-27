<?php

namespace HelpMeAbstract\Entity;

use Doctrine\ORM\Mapping as ORM;
use HelpMeAbstract\Entity\Behavior\HasCreatedDate;
use HelpMeAbstract\Entity\Behavior\HasUuid;
use HelpMeAbstract\Entity\Comment\Snippet;

/**
 * @ORM\Entity()
 * @ORM\Table( name="comments")
 */
class Comment
{
    use HasUuid;
    use HasCreatedDate;

    /**
     * @ORM\Embedded(class = "HelpMeAbstract\Entity\Comment\Snippet")
     */
    private $contents;

    /**
     * @ORM\Column(
     *     type="boolean",
     *     name="has_been_edited",
     *     options={"default":false}
     * )
     *
     * @var bool
     */
    private $hasBeenEdited = false;

    /**
     * @ORM\ManyToOne(
     *      targetEntity="HelpMeAbstract\Entity\Revision",
     *      inversedBy="comments"
     * )
     * @ORM\JoinColumn(name="revision_id", referencedColumnName="id", nullable=false)
     *
     * @var Revision
     */
    private $revision;

    /**
     * @ORM\ManyToOne(targetEntity="HelpMeAbstract\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false)
     *
     * @var User
     */
    private $author;

    /**
     * @param User     $user
     * @param Revision $revision
     * @param Snippet  $snippet
     */
    public function __construct(User $user, Revision $revision, Snippet $snippet)
    {
        $this->author = $user;
        $this->revision = $revision;
        $this->contents = $snippet;
    }

    /**
     * @return User
     */
    public function getAuthor() : User
    {
        return $this->author;
    }

    /**
     * @return Snippet
     */
    public function getContents() : Snippet
    {
        return $this->contents;
    }

    /**
     * @return Revision
     */
    public function getRevision() : Revision
    {
        return $this->revision;
    }

    /**
     * @return bool
     */
    public function hasBeenEdited() : bool
    {
        return $this->hasBeenEdited;
    }
}
