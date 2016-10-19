<?php

namespace HelpMeAbstract\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use HelpMeAbstract\Entity\Behavior\HasCreatedDate;
use HelpMeAbstract\Entity\Behavior\HasUuid;
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
     * @var User
     */
    private $user;

    /**
     * @var ArrayCollection
     */
    private $comments;

    public function __construct(User $user, int $abstractId = null)
    {
        $this->comments = new ArrayCollection();

        $this->user = $user;
        $this->submissionIdentifier = $abstractId ?: rand();
    }

    /**
     * @return int
     */
    public function getSubmissionIdentifier() : int
    {
        return $this->submissionIdentifier;
    }

    /**
     * @return User
     */
    public function getUser() : User
    {
        return $this->user;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments() : ArrayCollection
    {
        return $this->comments;
    }
}
