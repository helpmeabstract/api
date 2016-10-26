<?php

namespace HelpMeAbstract\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use HelpMeAbstract\Entity\Behavior\HasCreatedDate;
use HelpMeAbstract\Entity\Behavior\HasUuid;
use HelpMeAbstract\Entity\Notification\Subject;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity(repositoryClass="HelpMeAbstract\Repository\RevisionRepository")
 * @ORM\Table( name="revisions")
 *
 * @ORM\HasLifecycleCallbacks
 */
class Revision
{
    use HasCreatedDate;
    use HasUuid;

    /**
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @var Uuid
     */
    private $submissionIdentifier;

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
     *     type="uuid",
     *     name="submission_identifier"
     * )
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @var Uuid
     */
    private $submissionIdentifier;

    /**
     * @ORM\ManyToOne(targetEntity="HelpMeAbstract\Entity\User")
     *
     * @var User
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity="HelpMeAbstract\Entity\Comment", mappedBy="revision")
     *
     * @var Comment[]|ArrayCollection
     */
    private $comments;

    public function __construct(User $user, string $body, string $submissionId = null)
    {
        $this->comments = new ArrayCollection();

        $this->author = $user;
        $this->body = $body;
        $this->submissionIdentifier = $submissionId ?: Uuid::getFactory()->uuid4();
    }

    /**
     * @return {
     */
    public function getSubmissionIdentifier() : Uuid
    {
        return $this->submissionIdentifier;
    }

    /**
     * @return User
     */
    public function getAuthor() : User
    {
        return $this->author;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments() : ArrayCollection
    {
        return $this->comments;
    }

    public function getUrl()  : string
    {
        // TODO: Implement getUrl() method.
    }

    public function getExcerpt()  : string
    {
        // TODO: Implement getExcerpt() method.
    }

    public function getHeadline()  : string
    {
        // TODO: Implement getHeadline() method.
    }
}
