<?php

namespace HelpMeAbstract\Entity;

use Doctrine\ORM\Mapping as ORM;
use HelpMeAbstract\Entity\Behavior\HasCreatedDate;
use HelpMeAbstract\Entity\Behavior\HasUuid;
use HelpMeAbstract\Entity\Notification\Subject;

/**
 * @ORM\Entity()
 * @ORM\Table( name="comments")
 */
class Comment implements Subject
{
    use HasUuid;
    use HasCreatedDate;

    /**
     * @ORM\Column(
     *      type="text"
     * )
     *
     * @var string
     */
    private $body;

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
     * @ORM\ManyToOne(targetEntity="HelpMeAbstract\Entity\Revision", inversedBy="comments")
     *
     * @var Revision
     */
    private $revision;

    /**
     * @ORM\ManyToOne(targetEntity="HelpMeAbstract\Entity\User", inversedBy="comments")
     *
     * @var User
     */
    private $author;

    /**
     * @param User     $user
     * @param Revision $revision
     * @param string   $body
     */
    public function __construct(User $user, Revision $revision, string $body)
    {
        $this->author = $user;
        $this->revision = $revision;
        $this->body = $body;
    }

    /**
     * @return User
     */
    public function getAuthor() : User
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * @return Revision
     */
    public function getRevision() : Revision
    {
        return $this->revision;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body)
    {
        $this->body = $body;
        $this->hasBeenEdited = true;
    }

    /**
     * @return string
     */
    public function getUrl() : string
    {
        // TODO: Implement getUrl() method.
    }

    /**
     * @return string
     */
    public function getExcerpt() : string
    {
        // TODO: Implement getExcerpt() method.
    }

    /**
     * @return string
     */
    public function getHeadline() : string
    {
        // TODO: Implement getHeadline() method.
    }

    /**
     * @return bool
     */
    public function hasBeenEdited() : bool
    {
        return $this->hasBeenEdited;
    }
}
