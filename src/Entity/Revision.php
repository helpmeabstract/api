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

    const SESSION_TYPE_LIGHTNING = 'lightning';
    const SESSION_TYPE_HALF_HOUR = 'half-hour';
    const SESSION_TYPE_FULL_HOUR = 'full-hour';
    const SESSION_TYPE_TUTORIAL = 'tutorial';

    const VALID_SESSION_TYPES = [
        self::SESSION_TYPE_LIGHTNING,
        self::SESSION_TYPE_HALF_HOUR,
        self::SESSION_TYPE_FULL_HOUR,
        self::SESSION_TYPE_TUTORIAL,
    ];

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
     *      type="text"
     * )
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(
     *      type="text",
     *      name="session_type",
     *      nullable=true
     * )
     *
     * @var string
     */
    private $sessionType;

    /**
     * @ORM\Column(
     *      type="integer",
     *      name="max_characters",
     *      nullable=true
     * )
     *
     * @var int
     */
    private $maxCharacters;

    /**
     * @ORM\Column(
     *     type="uuid",
     *     name="proposal_id",
     *     nullable=false
     * )
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     *
     * @var Uuid
     */
    private $proposalId;

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

    public function __construct(
        string $body,
        string $title,
        UuidInterface $submissionId,
        User $user,
        string $sessionType = null,
        int $maxCharacters = null
    ) {
        $this->comments = new ArrayCollection();

        $this->author = $user;
        $this->body = $body;
        $this->proposalId = $submissionId;
        $this->title = $title;
        $this->sessionType = $sessionType;
        $this->maxCharacters = $maxCharacters;
    }

    /**
     * @return Uuid
     */
    public function getProposalId() : Uuid
    {
        return $this->proposalId;
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

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return int
     */
    public function getSessionType()
    {
        return $this->sessionType;
    }

    /**
     * @param int $sessionType
     */
    public function setSessionType($sessionType)
    {
        $this->sessionType = $sessionType;
    }

    /**
     * @return string
     */
    public function getMaxCharacters()
    {
        return $this->maxCharacters;
    }

    /**
     * @param string $maxCharacters
     */
    public function setMaxCharacters($maxCharacters)
    {
        $this->maxCharacters = $maxCharacters;
    }
}
