<?php

namespace HelpMeAbstract\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use HelpMeAbstract\Entity\Behavior\HasCreatedDate;
use HelpMeAbstract\Entity\Behavior\HasUuid;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

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
     *     name="submission_identifier",
     *     nullable=false
     * )
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @var Uuid
     */
    private $submissionIdentifier;

    /**
     * @ORM\ManyToOne(targetEntity="HelpMeAbstract\Entity\User")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false)
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

    public function __construct(User $user, string $body, UuidInterface $submissionId = null)
    {
        $this->comments = new ArrayCollection();

        $this->author = $user;
        $this->body = $body;
        $this->submissionIdentifier = $submissionId ?: Uuid::uuid4();
    }

    /**
     * @return Uuid
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

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
}
